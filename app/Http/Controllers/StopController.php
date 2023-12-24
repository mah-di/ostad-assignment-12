<?php

namespace App\Http\Controllers;

use App\Models\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class StopController extends Controller
{
    public function index()
    {
        $stops = Stop::all();

        return view('pages.stop-index', compact('stops'));
    }

    public function create()
    {
        return view('pages.stop-create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:'.Stop::class]
        ]);

        Stop::create($validatedData);

        return Redirect::route('stop.create')->with('status', 'stop-created');
    }

    public function destroy(string $id)
    {}

}
