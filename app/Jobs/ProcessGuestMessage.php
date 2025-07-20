<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Http;

class ProcessGuestMessage implements ShouldQueue
{
    use Dispatchable, Queueable;

    public $message;
    public $sessionId;

    public function __construct($message, $sessionId)
    {
        $this->message = $message;
        $this->sessionId = $sessionId;
    }

    public function handle()
    {
        // Enviar a N8N
        Http::timeout(30)->post(env('N8N_WEBHOOK_URL'), [
            'query' => $this->message,
            'session_id' => $this->sessionId,
            'callback_url' => route('api.guest-chat.receive'),
        ]);
    }
}
