<?php

namespace App\Listeners;

use App\Events\JourneyCreated;
use App\Events\TripCreated;
use App\Models\Journey;
use App\Models\Trip;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateTrips
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
    public function handle(JourneyCreated $event): void
    {
        $journey = $event->journey;

        $stops = [];

        $stops[] = $journey->route->origin_id;

        foreach ($journey->route->stops as $stop) $stops[] = $stop->id;

        $stops[] = $journey->route->destination_id;

        $len = count($stops);

        for($i=0; $i<$len-1; $i++)
        {
            for ($j=$i+1; $j<$len; $j++)
            {
                $trip = Trip::create([
                    'journey_id' => $journey->id,
                    'route_id' => $journey->route_id,
                    'origin_id' => $stops[$i],
                    'destination_id' => $stops[$j],
                ]);

                if ($trip->origin_id == $journey->route->origin_id)
                {
                    event(new TripCreated($trip, true));
                } else {
                    event(new TripCreated($trip, false));
                }

            }
        }
    }
}
