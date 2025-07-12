<?php

namespace App\Livewire\User;

use App\Models\Document;
use App\Models\DocumentCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageDocuments extends Component
{
    use WithFileUploads;

    public $file;
    public $document_category_id;
    public $confirmingDocumentDeletion = false;
    public $documentIdToDelete;

    protected $rules = [
        'file' => 'required|mimes:pdf,doc,docx,txt|max:10240', // 10MB Max
        'document_category_id' => 'required|exists:document_categories,id',
    ];

    /**
     * Guarda el documento subido, descuenta los tokens y lo deja listo para el análisis.
     */
    public function saveDocument()
    {
        $user = Auth::user();

        // Se asegura de que el usuario tenga una compañía asociada, creándola si es necesario.
        $company = $user->userCompany;
        if (!$company) {
            $company = $user->userCompany()->create([
                'name' => $user->name . "'s Company",
                'summary' => 'Compañía creada automáticamente para ' . $user->name,
            ]);
            $user->load('userCompany');
            $company = $user->userCompany;
        }

        // Bloquea la subida para usuarios del plan 'Gratis' (a menos que sean administradores).
        if (!$user->isAdmin() && $user->hasPlan('Gratis')) {
            $this->addError('file', 'Debes mejorar tu plan para poder subir documentos.');
            return;
        }

        $this->validate();

        // Guarda el archivo en el disco 'private' (S3/R2).
        $path = $this->file->store('documents', 'private');

        // Calcula el coste en tokens y verifica si el usuario tiene suficientes.
        if (!$user->isAdmin()) {
            $content = Storage::disk('private')->get($path);
            $tokenCost = (int) (strlen($content) / 4);
            
            if (!$user->hasAvailableTokens($tokenCost)) {
                // Si no hay suficientes tokens, borra el archivo y muestra un error.
                Storage::disk('private')->delete($path);
                $this->addError('file', 'No tienes suficientes tokens para este documento.');
                return;
            }
            // Si hay tokens, los descuenta inmediatamente.
            $user->increment('tokens_used', $tokenCost);
        }

        // Crea el registro del documento en la base de datos con estado 'uploaded'.
        $company->documents()->create([
            'document_category_id' => $this->document_category_id,
            'original_filename' => $this->file->getClientOriginalName(),
            'storage_path' => $path,
            'status' => 'uploaded', // Estado inicial que indica que está listo para ser analizado.
        ]);

        $this->reset(['file', 'document_category_id']);
        $this->dispatch('show-toast', message: 'Document uploaded successfully. Ready to be analyzed.', type: 'success');
    }

    /**
     * Inicia el workflow de n8n para analizar un documento específico.
     */
    public function startAnalysis($documentId)
    {
        $document = Document::findOrFail($documentId);

        // Actualiza el estado para que el usuario vea que el proceso ha comenzado.
        $document->update(['status' => 'processing']);
        $this->dispatch('show-toast', message: 'Analysis has started...', type: 'info');

        // Llama al webhook de n8n para iniciar el análisis.
        $n8nWebhookUrl = env('N8N_ANALYSIS_WEBHOOK_URL');

        Http::post($n8nWebhookUrl, [
            'document_id' => $document->id,
            's3_path' => $document->storage_path,
            'callback_url' => route('api.documents.analysis-complete'),
        ]);
    }

    /**
     * Muestra el modal de confirmación para borrar un documento.
     */
    public function confirmDocumentDeletion($documentId)
    {
        $this->documentIdToDelete = $documentId;
        $this->confirmingDocumentDeletion = true;
    }

    /**
     * Borra el documento seleccionado.
     */
    public function deleteDocument()
    {
        $document = Document::where('id', $this->documentIdToDelete)
                            ->whereHas('userCompany', function ($query) {
                                $query->where('user_id', Auth::id());
                            })
                            ->firstOrFail();

        Storage::disk('private')->delete($document->storage_path);
        $document->delete();

        $this->confirmingDocumentDeletion = false;
        $this->dispatch('show-toast', message: 'Document deleted successfully.', type: 'info');
    }

    /**
     * Genera una URL segura y temporal para descargar un documento.
     */
    public function downloadDocument($documentId)
    {
        $document = Document::where('id', $documentId)
                            ->whereHas('userCompany', function ($query) {
                                $query->where('user_id', Auth::id());
                            })
                            ->firstOrFail();

        $url = Storage::disk('private')->temporaryUrl(
            $document->storage_path,
            now()->addMinutes(5),
            [
                'ResponseContentDisposition' => 'attachment; filename="' . $document->original_filename . '"'
            ]
        );

        return redirect()->to($url);
    }

    /**
     * Renderiza el componente.
     */
    public function render()
    {
        $user = Auth::user()->load(['plan', 'userCompany.documents.category']);
        
        return view('livewire.user.manage-documents', [
            'documents' => $user->userCompany->documents ?? collect(),
            'categories' => DocumentCategory::orderBy('name')->get(),
            'tokens_used' => $user->tokens_used,
            'token_limit' => $user->isAdmin() ? 'Ilimitado' : ($user->plan->token_limit ?? 0),
            'userPlan' => $user->plan,
        ])->layout('layouts.app');
    }
}
