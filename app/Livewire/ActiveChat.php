<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
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

    // Title editing
    public $isEditingTitle = false;
    public $editingTitle = '';

    protected $listeners = ['conversationSelected', 'conversationCleared'];

    public function mount()
    {
        $this->loadLatestConversation();
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
        
        // Get companies here to set a default value if needed
        $companies = Auth::user()->userCompanies;

        $this->settings = $this->activeConversation->settings ?? [
            'data_source' => 'both',
            'user_company_id' => $companies->first()?->id,
            'search_country' => '',
            'search_industry' => '',
            'search_target' => 'businesses',
        ];
    }

    /**
     * Loads the most recent conversation on initial page load.
     */
    public function loadLatestConversation()
    {
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
     * Saves the current chat settings to the database.
     */
    public function saveSettings()
    {
        if ($this->activeConversation) {
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
    }

    /**
     * Renders the component view.
     */
    public function render()
    {
        // We fetch the companies collection here, right before rendering.
        // This is the safest pattern and avoids hydration issues.
        $companies = Auth::user()->userCompanies;

        return view('livewire.active-chat', [
            'companies' => $companies,
        ]);
    }
}