<?php

namespace App\Http\Controllers;

use App\Events\BookingMade;
use App\Models\Booking;
use App\Models\Fare;
use App\Models\Seat;
use App\Models\Stop;
use App\Models\Ticket;
use App\Models\Trip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TripController extends Controller
{

    public function searchTrip(Request $request)
    {
        $minDate = Carbon::now()->format('Y-m-d');

        $stops = Stop::all();

        if ($request->date === null and $request->origin_id === null and $request->destination_id === null)
        {
            return view('pages.trip-search', compact('minDate', 'stops'));
        }

        global $validatedData;

        $validatedData = $request->validate([
            'date' => ['required', 'date'],
            'origin_id' => ['required'],
            'destination_id' => ['required'],
        ]);

        $trips = Trip::whereHas('journey', function ($query) {
                global $validatedData;

                return $query->whereDate('departure', '=', $validatedData['date']);
            })
            ->with([
                'seats' => function ($query) {
                    return $query->where('available', '=', true);
                },
                'journey' => function ($query) {
                    return $query->with('route');
                },
                'origin',
                'destination'
            ])
            ->where(['origin_id' => $validatedData['origin_id'], 'destination_id' => $validatedData['destination_id']])
            ->get();

        $fare = Fare::where(['origin_id' => $validatedData['origin_id'], 'destination_id' => $validatedData['destination_id']])->with(['origin', 'destination'])->first();

        return view('pages.trip-search', [...$validatedData, 'minDate' => $minDate, 'stops' => $stops, 'trips' => $trips, 'fare' => $fare]);
    }

}
