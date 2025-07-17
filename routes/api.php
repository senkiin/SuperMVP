<?php

use App\Events\ChatMessageSent;
use App\Events\DocumentStatusUpdated;
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

Route::post('/chat/send', function (Request $request) {
    $request->validate(['message' => 'required|string|max:2000']);

    // Llamada al nuevo webhook de n8n para el chat
    $response = Http::post(env('N8N_CHAT_WEBHOOK_URL'), [
        'query' => $request->message,
        'user_id' => auth()->id(),
        'callback_url' => route('api.chat.receive'), // Le decimos a n8n a dónde responder
    ]);

    // Simplemente confirmamos que la petición se envió, no esperamos la respuesta de la IA aquí.
    return $response->json();
})->middleware('auth:sanctum')->name('api.chat.send');


// --- NUEVA RUTA PARA QUE N8N DEVUELVA LA RESPUESTA DEL CHAT ---
Route::post('/chat/receive', function (Request $request) {
    // Validamos que la petición venga de n8n con nuestro token secreto.
    if ($request->header('Authorization') !== 'Bearer ' . env('N8N_CALLBACK_SECRET')) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'user_id' => 'required|integer|exists:users,id',
        'message' => 'required|array',
        'message.sender' => 'required|string|in:ai',
        'message.content' => 'required|string',
    ]);

    // Disparamos el evento a través de Pusher al canal privado del usuario.
    broadcast(new ChatMessageSent($request->user_id, $request->message))->toOthers();
    
    return response()->json(['message' => 'Message broadcasted successfully.']);
})->name('api.chat.receive');