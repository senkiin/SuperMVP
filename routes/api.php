<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Document;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/documents/analysis-complete', function (Request $request) {
    // Validar que la petición venga de n8n (p.ej. con un token secreto)
    if ($request->header('Authorization') !== 'Bearer ' . env('N8N_CALLBACK_SECRET')) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $request->validate([
        'document_id' => 'required|integer|exists:documents,id',
        'status' => 'required|string|in:processed,failed',
    ]);
    
    $document = Document::find($request->document_id);
    $document->update(['status' => $request->status]);

    // TODO: Enviar una notificación en tiempo real al usuario (p.ej. con Laravel Echo)
    // para que la alerta "Análisis terminado" aparezca automáticamente.

    return response()->json(['message' => 'Status updated successfully']);
})->name('api.documents.analysis-complete');
