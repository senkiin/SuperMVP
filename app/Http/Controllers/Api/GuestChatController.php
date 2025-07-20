<?php

// app/Http/Controllers/Api/GuestChatController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\GuestChatMessageReceived;

class GuestChatController extends Controller
{
    /**
     * Receive response from N8N workflow and send to Livewire component
     */
    public function receiveResponse(Request $request)
    {
        $content = $request->input('content');
        $sessionId = $request->input('session_id');

        // Broadcast via Pusher to the specific guest session
        broadcast(new GuestChatMessageReceived($content, $sessionId));

        return response()->json(['success' => true]);
    }
}
