<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking;
use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'passenger' => $request->user()->passenger,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function showDashboard(Request $request)
    {
        if (!$request->user()->is_admin) return view('dashboard');

        $data = [];

        $data['revenueToday'] = Booking::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('payable');
        $data['revenueThisMonth'] = Booking::whereYear('created_at', '=', Carbon::now()->year)->whereMonth('created_at', '=', Carbon::now()->month)->sum('payable');
        $data['revenueLastMonth'] = Booking::whereYear('created_at', '=', Carbon::now()->subMonth()->year)->whereMonth('created_at', '=', Carbon::now()->subMonth()->month)->sum('payable');
        $data['revenueAlltime'] = Booking::sum('payable');

        $data['routeRevenues'] = Route::with([
                'bookings' => fn ($query) => $query->sum('payable')
            ])->get();

        return view('dashboard', $data);
    }
}
