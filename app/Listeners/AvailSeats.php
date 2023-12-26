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

        $finalDestinationId = $booking->route->destination_id;

        foreach($booking->tickets as $ticket)
        {
            $seat = $ticket->seat;

            $row = $seat->row;

            $column = $seat->column;

            $ticket->delete();

            $tripId = Trip::where([
                    'origin_id' => $destinationId,
                    'destination_id' => $finalDestinationId,
                ])
                ->pluck('id')
                ->first();

            $otherBookingExists = Seat::where([
                'trip_id' =>$tripId,
                'row' => $row,
                'column' => $column,
                'available' => false
            ])->exists();

            if ($otherBookingExists)
            {
                $seat->available = true;

                $seat->save();

                return;
            }

            Seat::where([
                    'journey_id' => $journeyId,
                    'row' => $row,
                    'column' => $column,
                ])
                ->update([
                    'available' => false,
                ]);

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
        }
    }
}
