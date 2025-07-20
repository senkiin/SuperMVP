<?php

use App\Events\ChatMessageSent;
use App\Http\Controllers\Api\GuestChatController;
use App\Events\DocumentStatusUpdated;
use App\Events\GuestChatMessageReceived;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
Route::post('/guest-chat/send', function (Request $request) {
    $request->validate([
        'message' => 'required|string|max:2000',
        'session_id' => 'required|string'
    ]);

    // Llamada al webhook de n8n para usuarios invitados
    $response = Http::post(env('N8N_CHAT_GUEST_WEBHOOK_URL'), [
        'query' => $request->message,
        'session_id' => $request->session_id,
        'callback_url' => route('api.guest-chat.receive'),
    ]);

    return $response->json();
})->name('api.guest-chat.send');

Route::post('/guest-chat/receive', function(Request $request) {
    $content = $request->input('content');
    $sessionId = $request->input('session_id');

    // Enviar via Pusher
    broadcast(new GuestChatMessageReceived($content, $sessionId));

    return response()->json(['success' => true]);
});
