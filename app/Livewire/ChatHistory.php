<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatConversation;

class ChatHistory extends Component
{
    public $conversations;

    protected $listeners = ['conversationCreated' => 'loadConversations'];

    public function mount()
    {
        $this->loadConversations();
    }

    public function loadConversations()
    {
        $this->conversations = Auth::user()->conversations()->latest()->get();
    }

    public function selectConversation($conversationId)
    {
        $this->dispatch('conversationSelected', $conversationId);
    }

    public function newConversation()
    {
        $newConv = Auth::user()->conversations()->create([
            'title' => 'New Conversation ' . now()->format('H:i'),
        ]);
        $this->loadConversations();
        $this->selectConversation($newConv->id);
    }

    public function render()
    {
        return view('livewire.chat-history');
    }
}
