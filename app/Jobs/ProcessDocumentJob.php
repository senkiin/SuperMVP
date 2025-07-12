<?php

namespace App\Jobs;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Document $document)
    {
    }

    public function handle(): void
    {
        $user = $this->document->userCompany->user;
        
        // 1. Leer el contenido del documento desde el disco 'private' (S3).
        $content = Storage::disk('private')->get($this->document->storage_path);
        if (!$content) {
            $this->document->update(['status' => 'failed']);
            // Opcional: Notificar al usuario que hubo un error al leer el archivo.
            return;
        }

        // 2. Calcular los tokens.
        $tokenCost = (int) (strlen($content) / 4);

        // 3. Comprobar si el usuario tiene tokens.
        if (!$user->hasAvailableTokens($tokenCost)) {
            $this->document->update(['status' => 'failed']);
            // Borramos el archivo de S3 si no hay tokens.
            Storage::disk('private')->delete($this->document->storage_path);
            return;
        }

        // 4. Actualizar el contador de tokens del usuario.
        $user->increment('tokens_used', $tokenCost);

        // 5. Actualizar el estado del documento.
        $this->document->update(['status' => 'processed']);
        
    }
}
