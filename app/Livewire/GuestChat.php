<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class GuestChat extends Component
{
    public $messages = [];
    public $newMessage = '';
    public $loading = false;
    public $sessionId;

    public function mount()
    {
        // Generate a unique session ID for the guest user
        $this->sessionId = session()->getId();

        // Add welcome message in English
        $this->messages[] = [
            'sender' => 'ai',
            'content' => 'Hello! I\'m your virtual assistant. I can help you with general information and answer your questions. For advanced features like custom document analysis, you can [register here](/register).',
            'timestamp' => now()->toDateTimeString()
        ];
    }

    /**
     * Sends a message from the guest user.
     */
    public function sendMessage()
    {
        if (empty($this->newMessage)) return;

        $userMessageContent = $this->newMessage;

        // Add user message to the conversation
        $this->messages[] = [
            'sender' => 'user',
            'content' => $userMessageContent,
            'timestamp' => now()->toDateTimeString()
        ];

        $this->loading = true;
        $this->newMessage = '';
        $this->dispatch('messages-updated');

        // Call N8N guest workflow
        $this->callGuestWorkflow($userMessageContent);
    }

    /**
     * Calls the N8N guest workflow and handles the response.
     */
    private function callGuestWorkflow($message)
    {
        try {
            $response = Http::timeout(30)->post(env('N8N_CHAT_GUEST_WEBHOOK_URL'), [
                'query' => $message,
                'session_id' => $this->sessionId,
                'callback_url' => route('api.guest-chat.receive'),
            ]);

            if (!$response->successful()) {
                $this->addErrorMessage();
            }
            // If successful, the response will come via Pusher
        } catch (\Exception $e) {
            $this->addErrorMessage();
        }
    }

    /**
     * Adds an AI response message to the conversation.
     */
    public function addAiMessage($content)
    {
        $this->messages[] = [
            'sender' => 'ai',
            'content' => $content,
            'timestamp' => now()->toDateTimeString()
        ];
        $this->loading = false;
        $this->dispatch('messages-updated');
    }

    /**
     * Adds an error message when something goes wrong.
     */
    private function addErrorMessage()
    {
        $this->messages[] = [
            'sender' => 'ai',
            'content' => 'Sorry, an error occurred. Please try again in a few moments.',
            'timestamp' => now()->toDateTimeString()
        ];
        $this->loading = false;
        $this->dispatch('messages-updated');
    }

    /**
     * Clears the conversation (for guests).
     */
    public function clearConversation()
    {
        $this->messages = [];
        $this->mount(); // Re-add welcome message
    }

    public function render()
    {
        return view('livewire.guest-chat');
    }
}
