<?php

namespace App\Events;

use App\Models\Document;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DocumentStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $document;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Document $document
     * @return void
     */
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // This will broadcast the event on a private channel named, for example, 'document-status.1'
        // where 1 is the ID of the user who owns the document.
        // This ensures only the correct user receives the update.
        return new PrivateChannel('document-status.' . $this->document->userCompany->user_id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        // We can customize the data that is sent with the event.
        // Here, we send the updated document's ID and its new status.
        return [
            'document_id' => $this->document->id,
            'status' => $this->document->status,
        ];
    }
}
