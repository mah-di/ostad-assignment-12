<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RouteController extends Controller
{

    public function index()
    {
        $routes = Route::with(['origin', 'destination'])->get();

        return view('pages.route-index', compact('routes'));
    }

    public function create()
    {
        $stops = Stop::all();

        return view('pages.route-create', compact('stops'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origin_id' => ['required', 'numeric'],
            'destination_id' => ['required', 'numeric'],
            'status' => ['required', 'in:up,down'],
            'name' => ['required', 'string', 'min:7', 'max:7', 'unique:'.Route::class],
        ]);

        if ($validatedData['origin_id'] == $validatedData['destination_id']) return Redirect::back()->with('destination_id', 'Destination cannot be the same as origin.')->withInput();

        $route = Route::updateOrCreate(
            ['origin_id' => $validatedData['origin_id'], 'destination_id' => $validatedData['destination_id']],
            $validatedData
        );

        $route->stops()->detach();

        $stops = $request->input('stops');

        foreach($stops as $stop)
        {
            if ($route->origin_id !== $stop and $route->destination_id !== $stop) $route->stops()->attach($stop);
        }

        return Redirect::back()->with('status', 'route-created');
    }

    public function show(string $id)
    {
        $route = Route::with(['origin', 'destination'])->findOrFail($id);

        return view('pages.route-show', compact('route'));
    }

}
