<?php

namespace App\Http\Controllers;

use App\Events\BookingCancelled;
use Carbon\Carbon;
use App\Models\Fare;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\Ticket;
use App\Models\Booking;
use App\Events\BookingMade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{

    public function allBookings()
    {
        $adminView = true;

        $bookings = Booking::with([
                'journey',
                'passenger' => fn ($query) => $query->with('user'),
                'trip' => fn ($query) => $query->with(['origin', 'destination'])
            ])
            ->latest()
            ->paginate(15);

        return view('pages.booking-index', compact('adminView', 'bookings'));
    }

    public function index(Request $request)
    {
        $bookings = Booking::where('cancelled', '=', false)
            ->with([
                'journey',
                'trip' => fn ($query) => $query->with(['origin', 'destination'])
            ])
            ->where('passenger_email', '=', $request->user()->email)
            ->latest()
            ->paginate(15);

        return view('pages.booking-index', compact('bookings'));
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

    public function show($id)
    {
        $booking = Booking::where('cancelled', '=', false)
            ->with([
                'passenger' =>fn ($query) => $query->with(['user']),
                'route' => fn ($query) => $query->with(['origin']),
                'journey' => fn ($query) => $query->with(['bus']),
                'trip' => fn ($query) => $query->with(['origin', 'destination']),
                'tickets' => fn ($query) => $query->with('seat')
            ])->findOrFail($id);

        return view('pages.booking-show', compact('booking'));
    }

    public function upcomingTrips(Request $request)
    {
        $bookings = Booking::with([
                'journey',
                'trip' => fn ($query) => $query->with(['origin', 'destination'])
            ])
            ->where([
                'passenger_email' => $request->user()->email,
                'cancelled' => false,
            ])
            ->get();

        $datetimeNow = Carbon::now()->format('Y-m-d H:i:s');

    return view('pages.booking-upcoming', compact('bookings', 'datetimeNow'));
    }

    public function cancelBooking(string $id)
    {
        Booking::where('id', '=', $id)
            ->update([
                'cancelled' => true
            ]);

        event(new BookingCancelled($id));

        return Redirect::route('booking.index')->with('status', 'booking-cancelled');
    }

}
