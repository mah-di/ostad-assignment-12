<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function index(Request $request)
    {
        $bookings = Booking::with([
                'journey',
                'trip' => fn ($query) => $query->with(['origin', 'destination'])
            ])
            ->where('passenger_email', '=', $request->user()->email)
            ->get();

        return view('pages.booking-index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::with([
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
        ->where('passenger_email', '=', $request->user()->email)
        ->get();

        $datetimeNow = Carbon::now()->format('Y-m-d H:i:s');

    return view('pages.booking-upcoming', compact('bookings', 'datetimeNow'));
    }

}
