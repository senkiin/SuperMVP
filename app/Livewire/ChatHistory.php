<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatConversation;

class ChatHistory extends Component
{
    public $conversations;
    public $confirmingDeletion = null; // ID of conversation being confirmed for deletion

    protected $listeners = [
        'conversationCreated' => 'loadConversations',
        'conversationUpdated' => 'loadConversations'
    ];

    public function mount()
    {
        // Only load conversations if user is authenticated
        if (Auth::check()) {
            $this->loadConversations();
        } else {
            $this->conversations = collect(); // Empty collection for guests
        }
    }

    public function loadConversations()
    {
        // Guard against non-authenticated users
        if (!Auth::check()) {
            $this->conversations = collect();
            return;
        }

        $this->conversations = Auth::user()->conversations()->latest()->get();
    }

    public function selectConversation($conversationId)
    {
        // Only allow if user is authenticated
        if (!Auth::check()) {
            return;
        }

        $this->dispatch('conversationSelected', $conversationId);
    }

    public function newConversation()
    {
        // Only allow if user is authenticated
        if (!Auth::check()) {
            return;
        }

        $newConv = Auth::user()->conversations()->create([
            'title' => 'New Conversation ' . now()->format('H:i'),
        ]);
        $this->loadConversations();
        $this->selectConversation($newConv->id);
    }

    /**
     * Confirms deletion of a conversation.
     */
    public function confirmDelete($conversationId)
    {
        if (!Auth::check()) {
            return;
        }

        $this->confirmingDeletion = $conversationId;
    }

    /**
     * Cancels the deletion confirmation.
     */
    public function cancelDelete()
    {
        $this->confirmingDeletion = null;
    }

    /**
     * Deletes a conversation and all its messages.
     */
    public function deleteConversation($conversationId)
    {
        if (!Auth::check()) {
            return;
        }

        $conversation = Auth::user()->conversations()->findOrFail($conversationId);

        // Check if this is the currently active conversation
        $wasActive = request()->session()->get('active_conversation_id') == $conversationId;

        $conversation->delete();

        $this->confirmingDeletion = null;
        $this->loadConversations();

        // If we deleted the active conversation, select another one or clear
        if ($wasActive) {
            $latest = $this->conversations->first();
            if ($latest) {
                $this->selectConversation($latest->id);
            } else {
                $this->dispatch('conversationCleared');
            }
        }

        $this->dispatch('show-toast', message: 'Conversation deleted!', type: 'success');
    }

    public function render()
    {
        return view('livewire.chat-history');
    }
}
