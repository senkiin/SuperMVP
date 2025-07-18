<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ActiveChat extends Component
{
    public ?ChatConversation $activeConversation = null;
    public $messages = [];
    public $newMessage = '';
    public $loading = false;

    // Settings Panel
    public $showSettings = false;
    public $settings = [];
    public $selectedDocuments = []; // Array of document IDs

    // Title editing
    public $isEditingTitle = false;
    public $editingTitle = '';

    protected $listeners = ['conversationSelected', 'conversationCleared'];

    public function mount()
    {
        // Only load conversations if user is authenticated
        if (Auth::check()) {
            $this->loadLatestConversation();
        }
    }

    /**
     * Loads the selected conversation and its settings.
     */
    public function conversationSelected($conversationId)
    {
        $this->activeConversation = ChatConversation::findOrFail($conversationId);
        $this->messages = $this->activeConversation->messages->map(fn($msg) => $msg->toArray())->toArray();

        // Reset title editing state
        $this->isEditingTitle = false;
        $this->editingTitle = $this->activeConversation->title;

        // Get user company
        $userCompany = Auth::user()->userCompany;

        $this->settings = $this->activeConversation->settings ?? [
            'data_source' => 'both',
            'user_company_id' => $userCompany?->id,
            'search_country' => '',
            'search_industry' => '',
            'search_target' => 'businesses',
        ];

        // Load selected documents from conversation settings
        $this->selectedDocuments = $this->settings['selected_documents'] ?? [];
    }

    /**
     * Loads the most recent conversation on initial page load.
     */
    public function loadLatestConversation()
    {
        // Only load if user is authenticated
        if (!Auth::check()) {
            return;
        }

        $latest = Auth::user()->conversations()->latest()->first();
        if ($latest) {
            $this->conversationSelected($latest->id);
        }
    }

    /**
     * Starts editing the conversation title.
     */
    public function startEditingTitle()
    {
        if (!$this->activeConversation) return;

        $this->isEditingTitle = true;
        $this->editingTitle = $this->activeConversation->title;
    }

    /**
     * Saves the edited title.
     */
    public function saveTitle()
    {
        if (!$this->activeConversation) return;

        $this->validate([
            'editingTitle' => 'required|string|max:255',
        ]);

        $this->activeConversation->update([
            'title' => $this->editingTitle,
        ]);

        $this->isEditingTitle = false;

        // Notify chat history to refresh
        $this->dispatch('conversationUpdated');
        $this->dispatch('show-toast', message: 'Title updated!', type: 'success');
    }

    /**
     * Cancels title editing.
     */
    public function cancelEditingTitle()
    {
        $this->isEditingTitle = false;
        $this->editingTitle = $this->activeConversation?->title ?? '';
    }

    /**
     * Toggles document selection.
     */
    public function toggleDocument($documentId)
    {
        if (in_array($documentId, $this->selectedDocuments)) {
            $this->selectedDocuments = array_values(array_filter($this->selectedDocuments, fn($id) => $id != $documentId));
        } else {
            $this->selectedDocuments[] = $documentId;
        }
    }

    /**
     * Selects all documents.
     */
    public function selectAllDocuments()
    {
        $userCompany = Auth::user()->userCompany;
        if ($userCompany && $userCompany->id == $this->settings['user_company_id']) {
            $this->selectedDocuments = $userCompany->documents
                ->whereIn('status', ['completed', 'processed', 'Processed'])
                ->pluck('id')
                ->toArray();
        }
    }

    /**
     * Deselects all documents.
     */
    public function deselectAllDocuments()
    {
        $this->selectedDocuments = [];
    }

    /**
     * Checks if documents should be shown based on data source setting.
     */
    public function getShowDocumentSelectionProperty()
    {
        return in_array($this->settings['data_source'] ?? 'both', ['both', 'documents']);
    }

    /**
     * Debug method to check documents - remove after debugging
     */
    public function debugDocuments()
    {
        $user = Auth::user()->load('userCompany.documents.category');
        dd([
            'user_company' => $user->userCompany,
            'documents' => $user->userCompany?->documents,
            'settings' => $this->settings,
            'selected_company_id' => $this->settings['user_company_id'] ?? 'none',
        ]);
    }

    /**
     * Saves the current chat settings to the database.
     */
    public function saveSettings()
    {
        if ($this->activeConversation) {
            // Add selected documents to settings
            $this->settings['selected_documents'] = $this->selectedDocuments;

            $this->activeConversation->update([
                'user_company_id' => $this->settings['user_company_id'],
                'settings' => $this->settings,
            ]);
            $this->showSettings = false;
            $this->dispatch('show-toast', message: 'Settings saved!', type: 'success');
        }
    }

    /**
     * Sends a message from the user.
     */
    public function sendMessage()
    {
        if (empty($this->newMessage) || !$this->activeConversation) return;

        $userMessageContent = $this->newMessage;
        $this->messages[] = ['sender' => 'user', 'content' => $userMessageContent];
        $this->activeConversation->messages()->create(['user_id' => auth()->id(), 'sender' => 'user', 'content' => $userMessageContent]);

        $this->loading = true;
        $this->newMessage = '';
        $this->dispatch('messages-updated');

        // The real call to your API that triggers the n8n workflow would go here.
        // You can include $this->selectedDocuments in the API call
    }

    /**
     * Clears the active conversation when it's deleted.
     */
    public function conversationCleared()
    {
        $this->activeConversation = null;
        $this->messages = [];
        $this->isEditingTitle = false;
        $this->editingTitle = '';
        $this->selectedDocuments = [];
    }

    /**
     * Renders the component view.
     */
    public function render()
    {
        // Only render full chat if user is authenticated
        if (!Auth::check()) {
            return view('livewire.active-chat', [
                'companies' => collect(),
                'documents' => collect(),
            ]);
        }

        // We fetch the companies collection here, right before rendering.
        // This is the safest pattern and avoids hydration issues.
        $user = Auth::user()->load('userCompany');
        $companies = collect([$user->userCompany])->filter(); // Convert to collection and remove nulls

        // Get documents for the selected company
        $documents = collect();
        if (!empty($this->settings['user_company_id'])) {
            $selectedCompany = $companies->firstWhere('id', $this->settings['user_company_id']);
            if ($selectedCompany) {
                $documents = $selectedCompany->documents()
                    ->whereIn('status', ['completed', 'processed', 'Processed']) // Check multiple status formats
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
        }

        return view('livewire.active-chat', [
            'companies' => $companies,
            'documents' => $documents,
        ]);
    }
}
