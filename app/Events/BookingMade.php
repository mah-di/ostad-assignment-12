<?php

namespace App\Events;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Trip;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingMade
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket, $booking;

    /**
     * Create a new event instance.
     */
    public function __construct(Ticket $ticket, Booking $booking)
    {
        $this->ticket = $ticket;

        $this->booking = $booking;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
