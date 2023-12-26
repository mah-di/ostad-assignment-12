<?php

namespace App\Listeners;

use App\Events\BookingCancelled;
use App\Models\Seat;
use App\Models\Trip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AvailSeats
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
    public function handle(BookingCancelled $event): void
    {
        $booking = $event->booking;

        $journeyId = $booking->journey_id;

        $originId = $booking->trip->origin_id;

        $destinationId = $booking->trip->destination_id;

        foreach($booking->tickets as $ticket)
        {
            $seat = $ticket->seat;

            $row = $seat->row;

            $column = $seat->column;

            $ticket->delete();

            $tripIds = Trip::where([
                    'journey_id' => $journeyId,
                    'origin_id' => $originId,
                ])->pluck('id');

            Seat::whereIn('trip_id', $tripIds)
                ->where([
                    'row' => $row,
                    'column' => $column,
                ])
                ->update([
                    'available' => true
                ]);

            $tripIds = Trip::where([
                    'journey_id' => $journeyId,
                    'origin_id' => $destinationId,
                ])->pluck('id');

            Seat::whereIn('trip_id', $tripIds)
                ->where([
                    'row' => $row,
                    'column' => $column,
                ])
                ->update([
                    'available' => false
                ]);
        }
    }
}
