<?php

use App\Events\ChatMessageSent;
use App\Http\Controllers\Api\GuestChatController;
use App\Events\DocumentStatusUpdated;
use App\Events\GuestChatMessageReceived;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/documents/analysis-complete', function (Request $request) {
    if ($request->header('Authorization') !== 'Bearer ' . env('N8N_CALLBACK_SECRET')) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'document_id' => 'required|integer|exists:documents,id',
        'status' => 'required|string|in:processed,failed',
    ]);

    $document = Document::find($request->document_id);
    $document->update(['status' => $request->status]);

    // Disparamos el evento para notificar al frontend en tiempo real.
    broadcast(new DocumentStatusUpdated($document))->toOthers();

    return response()->json(['message' => 'Status updated successfully']);
})->name('api.documents.analysis-complete');

// --- RUTAS PARA USUARIOS AUTENTICADOS ---
Route::post('/chat/send', function (Request $request) {
    $request->validate(['message' => 'required|string|max:2000']);

    // Llamada al webhook de n8n para usuarios autenticados
    $response = Http::post(env('N8N_CHAT_WEBHOOK_URL'), [
        'query' => $request->message,
        'user_id' => auth()->id(),
        'callback_url' => route('api.chat.receive'),
    ]);

    return $response->json();
})->middleware('auth:sanctum')->name('api.chat.send');

Route::post('/chat/receive', function (Request $request) {
    if ($request->header('Authorization') !== 'Bearer ' . env('N8N_CALLBACK_SECRET')) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'message' => 'required|array',
        'message.sender' => 'required|string|in:ai',
        'message.content' => 'required|string',
    ]);

    broadcast(new ChatMessageSent($request->user_id, $request->message))->toOthers();

    return response()->json(['message' => 'Message broadcasted successfully.']);
})->name('api.chat.receive');

// --- RUTAS PARA USUARIOS INVITADOS ---
// En api.php - Actualizar la ruta guest-chat/receive

// Ruta principal para recibir respuestas de n8n
Route::post('/guest-chat/receive', function (Request $request) {
    // Log completo de la petición
    Log::info('=== N8N CALLBACK RECEIVED ===', [
        'all_data' => $request->all(),
        'headers' => $request->headers->all(),
        'raw_content' => $request->getContent()
    ]);

    // Verificar autenticación si está configurada
    if (env('N8N_CALLBACK_SECRET')) {
        $authHeader = $request->header('Authorization');
        $expectedAuth = 'Bearer ' . env('N8N_CALLBACK_SECRET');

        if ($authHeader !== $expectedAuth) {
            Log::error('Unauthorized callback attempt', [
                'received' => $authHeader,
                'expected' => $expectedAuth
            ]);
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // Extraer datos - compatible con múltiples formatos
    $content = $request->input('content') ?? $request->input('message');
    $sessionId = $request->input('session_id') ?? $request->input('sessionId');
    $messageId = $request->input('message_id') ?? $request->input('messageId');

    // Validación básica
    if (!$content || !$sessionId) {
        Log::error('Missing required data', [
            'content' => $content,
            'session_id' => $sessionId,
            'full_request' => $request->all()
        ]);
        return response()->json(['error' => 'Missing content or session_id'], 400);
    }

    try {
        // Guardar en cache con múltiples claves para máxima compatibilidad
        $ttl = 300; // 5 minutos

        // Clave general para el session
        $generalKey = "ai_response_{$sessionId}";
        Cache::put($generalKey, $content, $ttl);

        // Si hay messageId, guardar también con esa clave
        if ($messageId) {
            $specificKey = "ai_response_{$sessionId}_{$messageId}";
            Cache::put($specificKey, $content, $ttl);
        }

        // También guardar como objeto completo para debugging
        $fullResponse = [
            'content' => $content,
            'session_id' => $sessionId,
            'message_id' => $messageId,
            'timestamp' => now()->toDateTimeString()
        ];
        Cache::put("full_response_{$sessionId}", $fullResponse, $ttl);

        Log::info('Response cached successfully', [
            'general_key' => $generalKey,
            'specific_key' => $messageId ? "ai_response_{$sessionId}_{$messageId}" : null,
            'content_preview' => substr($content, 0, 100) . '...'
        ]);

        // Intentar broadcast via Pusher si está configurado
        try {
            broadcast(new GuestChatMessageReceived($content, $sessionId));
            Log::info('Pusher broadcast sent');
        } catch (\Exception $e) {
            Log::warning('Pusher broadcast failed, falling back to polling', [
                'error' => $e->getMessage()
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Response cached successfully',
            'session_id' => $sessionId,
            'message_id' => $messageId
        ]);
    } catch (\Exception $e) {
        Log::error('Callback processing failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return response()->json(['error' => 'Processing failed'], 500);
    }
})->name('api.guest-chat.receive');

// Ruta de polling para obtener respuestas
Route::get('/guest-chat/poll/{sessionId}/{messageId?}', function ($sessionId, $messageId = null) {
    Log::info('Polling request', [
        'session_id' => $sessionId,
        'message_id' => $messageId
    ]);

    // Buscar en diferentes claves de cache
    $keys = [];
    if ($messageId) {
        $keys[] = "ai_response_{$sessionId}_{$messageId}";
    }
    $keys[] = "ai_response_{$sessionId}";
    $keys[] = "full_response_{$sessionId}";

    foreach ($keys as $key) {
        $response = Cache::get($key);
        if ($response) {
            Log::info('Response found in cache', ['key' => $key]);

            // Limpiar la cache después de entregar
            Cache::forget($key);

            // Si es el objeto completo, extraer el contenido
            if (is_array($response) && isset($response['content'])) {
                $response = $response['content'];
            }

            return response()->json([
                'success' => true,
                'content' => $response,
                'found_with_key' => $key
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'No response yet'
    ]);
})->name('api.guest-chat.poll');

// Ruta de test para verificar que n8n puede alcanzar el servidor
Route::get('/guest-chat/test', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toDateTimeString(),
        'message' => 'Guest chat endpoint is working'
    ]);
})->name('api.guest-chat.test');

// Ruta para enviar mensajes a n8n (mejorada)
Route::post('/guest-chat/send', function (Request $request) {
    $request->validate([
        'message' => 'required|string|max:2000',
        'session_id' => 'required|string',
        'message_id' => 'nullable|string'
    ]);

    $webhookUrl = env('N8N_CHAT_GUEST_WEBHOOK_URL');

    if (!$webhookUrl) {
        Log::error('N8N webhook URL not configured');
        return response()->json(['error' => 'Chat service not configured'], 500);
    }

    Log::info('Sending to n8n webhook', [
        'url' => $webhookUrl,
        'message' => $request->message,
        'session_id' => $request->session_id
    ]);

    try {
        $response = Http::timeout(10)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])
            ->post($webhookUrl, [
                'query' => $request->message,
                'session_id' => $request->session_id,
                'message_id' => $request->message_id,
                'callback_url' => route('api.guest-chat.receive'),
                'timestamp' => now()->toDateTimeString()
            ]);

        Log::info('N8N webhook response', [
            'status' => $response->status(),
            'body' => $response->body()
        ]);

        if ($response->successful()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent to processing'
            ]);
        } else {
            return response()->json([
                'error' => 'Failed to process message',
                'details' => $response->body()
            ], $response->status());
        }
    } catch (\Exception $e) {
        Log::error('N8N webhook error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'Failed to send message',
            'message' => $e->getMessage()
        ], 500);
    }
})->name('api.guest-chat.send');
