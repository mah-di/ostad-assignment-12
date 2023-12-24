<?php

namespace App\Listeners;

use App\Events\TripCreated;
use App\Models\Seat;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSeats
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
    public function handle(TripCreated $event): void
    {
        $trip = $event->trip;

        $available = false;

        if ($event->mainRoute) $available = true;

        $seatRows = [
            'A' => [1, 2, 3, 4],
            'B' => [1, 2, 3, 4],
            'C' => [1, 2, 3, 4],
            'D' => [1, 2, 3, 4],
            'E' => [1, 2, 3, 4],
            'F' => [1, 2, 3, 4],
            'G' => [1, 2, 3, 4],
            'H' => [1, 2, 3, 4],
            'I' => [1, 2, 3, 4],
        ];

        foreach ($seatRows as $seatRow => $seatCols)
        {
            foreach ($seatCols as $seatCol)
            {
                Seat::create([
                    'trip_id' => $trip->id,
                    'row' => $seatRow,
                    'column' => $seatCol,
                    'available' => $available
                ]);
            }
        }
    }
}
