<?php

namespace App\Listeners;

use App\Events\BookingMade;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateSeats
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BookingMade $event): void
    {
        $ticket = $event->ticket;

        $booking = $event->booking;

        $journeyId = $booking->journey_id;

        $destinationId = $booking->trip->destination_id;

        $finalDestinationId = $booking->route->destination_id;

        if ($destinationId !== $finalDestinationId)
        {
            $tripIds = Trip::where([
                    'journey_id' => $journeyId,
                    'origin_id' => $destinationId
                ])->pluck('id');

            Seat::whereIn('trip_id', $tripIds)
                ->where([
                    'row' => $ticket->seat->row,
                    'column' => $ticket->seat->column,
                ])
                ->update([
                    'available' => true
                ]);
        }
    }
}
