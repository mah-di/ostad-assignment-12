<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();

        return view('pages.bus-index', compact('buses'));
    }

    public function create()
    {
        return view('pages.bus-create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'bus_no' => ['required', 'string', 'min:8', 'max:8', 'unique:'.Bus::class],
        ]);

        $validatedData['number_of_seats'] = 36;

        $bus = Bus::create($validatedData);

        return Redirect::route('bus.show', $bus->id);
    }

    public function show(string $id)
    {
        $bus = Bus::findOrFail($id);

        return view('pages.bus-show', compact('bus'));
    }

}
