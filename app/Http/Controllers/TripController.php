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

        global $data;

        $data = $request->validate([
            'date' => ['required', 'date'],
            'origin_id' => ['required'],
            'destination_id' => ['required'],
        ]);

        $trips = Trip::whereHas('journey', function ($query) {
                global $data;

                return $query->whereDate('departure', '=', $data['date']);
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
            ->where(['origin_id' => $data['origin_id'], 'destination_id' => $data['destination_id']])
            ->get();

        $fare = Fare::where(['origin_id' => $data['origin_id'], 'destination_id' => $data['destination_id']])->with(['origin', 'destination'])->first();

        return view('pages.trip-search', [...$data, 'minDate' => $minDate, 'stops' => $stops, 'trips' => $trips, 'fare' => $fare]);
    }

    public function bookTrip(string $id)
    {
        $trip = Trip::with(['seats', 'origin', 'destination'])->findOrFail($id);

        return view('pages.trip-book', compact('trip'));
    }

    public function confirmBooking(Request $request)
    {
        $seats = $request->input('seats');

        if (empty($seats))
        {
            return Redirect::back()->with('seats', 'Please select at least 1 seat.');
        }

        $trip = Trip::find($request->id);

        $fare = Fare::select('id')->where([
            'origin_id' => $trip->origin_id,
            'destination_id' => $trip->destination_id,
        ])->first();

        $email = $request->user()->email;

        $pin = $request->user()->id.Carbon::now()->format('sihdmy').$seats[0];

        $booking = Booking::create([
            'trip_id' => $trip->id,
            'route_id' => $trip->route_id,
            'journey_id' => $trip->journey_id,
            'passenger_email' => $email,
            'payable' => 0,
            'pin' => $pin
        ]);

        foreach ($seats as $seat)
        {
            $ticket = Ticket::create([
                'booking_id' => $booking->id,
                'seat_id' => $seat,
                'fare_id' => $fare->id,
            ]);

            $booking->payable += $ticket->fare->price;

            $tripIds = Trip::where([
                    'journey_id' => $booking->journey_id,
                    'origin_id' => $booking->trip->origin_id
                ])->pluck('id');

            Seat::whereIn('trip_id', $tripIds)
                ->where([
                    'row' => $ticket->seat->row,
                    'column' => $ticket->seat->column
                ])
                ->update([
                    'available' => false
                ]);

            event(new BookingMade($ticket, $booking));
        }

        $booking->save();

        return Redirect::route('booking.show', $booking->id);
    }

}
