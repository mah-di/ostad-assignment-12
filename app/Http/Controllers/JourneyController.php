<?php

namespace App\Http\Controllers;

use App\Events\JourneyCreated;
use App\Models\Bus;
use App\Models\Journey;
use App\Models\JourneyStop;
use App\Models\Route;
use App\Models\Stop;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JourneyController extends Controller
{

    public function index()
    {
        $journeys = Journey::with(['route' => function ($query) {
            return $query->with(['origin', 'destination']);
        }])->orderBy('departure', 'desc')->get();

        return view('pages.journey-index', compact('journeys'));
    }

    public function create()
    {
        $buses = Bus::all();

        $routes = Route::with('stops')->get();

        $minDatetime = Carbon::now('Asia/Dhaka')->addDays(3)->format('Y-m-d\T00:00');

        return view('pages.journey-create', compact('routes', 'buses', 'minDatetime'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'bus_id' => ['required', 'numeric', 'exists:'.Bus::class.',id'],
            'route_id' => ['required', 'numeric', 'exists:'.Route::class.',id'],
            'departure' => ['required', 'after:'.Carbon::now()->addDays(3)->format('d-m-Y')]
        ]);

        $validatedData['arrival'] = Carbon::parse($validatedData['departure'])->addHours(7);

        $journey = Journey::create($validatedData);

        event(new JourneyCreated($journey));

        return Redirect::back()->with('status', 'journey-created');
    }

    public function show(string $id)
    {
        $journey = Journey::with(['route' => function ($query) {
            return $query->with(['origin', 'destination']);
        }])->findOrFail($id);

        return view('pages.journey-show', compact('journey'));
    }

    public function edit(string $id)
    {
        $journey = Journey::with('route')->findOrFail($id);

        $buses = Bus::all();

        $dt = new DateTime($journey->departure);

        $minDatetime = $dt->format('Y-m-d\T00:00');

        return view('pages.journey-edit', compact('journey', 'buses', 'minDatetime'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'bus_id' => ['required', 'exists:'.Bus::class.',id'],
            'departure' => ['required', 'after:'.Carbon::now()->format('d-m-Y')]
        ]);

        Journey::where('id', $request->id)->update($validatedData);

        return Redirect::route('journey.show', $request->id)->with('status', 'journey-updated');
    }

}
