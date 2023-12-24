<?php

namespace App\Http\Controllers;

use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PassengerController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'contact' => ['required', 'min:1000000000', 'max:10000000000000', 'numeric', 'unique:passengers,contact,'.$request->id],
            'address' => ['nullable', 'string', 'max:500']
        ]);

        Passenger::where('id', $request->id)->update([
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        return Redirect::back()->with('status', 'passenger-updated');
    }
}
