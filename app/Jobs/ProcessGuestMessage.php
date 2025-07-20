<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
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
    Log::info('Processing message job', [
        'message' => $this->message, // Keep this line
        'session' => $this->sessionId,
        'webhook_url' => env('N8N_CHAT_WEBHOOK_URL')
    ]);

    try {
        $response = Http::timeout(30)->post(env('N8N_CHAT_WEBHOOK_URL'), [
            'query' => $this->message,
            'session_id' => $this->sessionId,
            'callback_url' => route('api.guest-chat.receive'),
        ]);

        Log::info('N8N response', ['status' => $response->status(), 'body' => $response->body()]);

        if (!$response->successful()) {
            Log::error('N8N webhook failed', ['response' => $response->body()]);
        }
    } catch (\Exception $e) {
        Log::error('N8N webhook error', ['error' => $e->getMessage()]);
    }
}
}
