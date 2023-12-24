<?php

namespace App\Http\Controllers;

use App\Models\Fare;
use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FareController extends Controller
{

    public function index()
    {
        $fares = Fare::with(['origin', 'destination'])->get();

        return view('pages.fare-index', compact('fares'));
    }

    public function create()
    {
        $stops = Stop::all();

        return view('pages.fare-create', compact('stops'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'origin_id' => ['required', 'numeric'],
            'destination_id' => ['required', 'numeric'],
            'price' => ['required', 'numeric'],
        ]);

        if ($validatedData['origin_id'] == $validatedData['destination_id']) return Redirect::back()->with('destination_id', 'Destination cannot be the same as origin.')->withInput();

        Fare::updateOrCreate(
            ['origin_id' => $validatedData['origin_id'], 'destination_id' => $validatedData['destination_id']],
            $validatedData
        );

        return Redirect::back()->with('status', 'fare-created');
    }

    public function show(string $id)
    {
        $fare = Fare::with(['origin', 'destination'])->findOrFail($id);

        return view('pages.fare-show', compact('fare'));
    }

    public function edit(string $id)
    {
        $fare = Fare::findOrFail($id);

        return view('pages.fare-edit', compact('fare'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'price' => ['required', 'numeric'],
        ]);

        Fare::where('id', $request->id)->update($validatedData);

        return Redirect::route('fare.show', $request->id);
    }

}
