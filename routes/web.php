<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\BusController;
use App\Http\Controllers\FareController;
use App\Http\Controllers\JourneyController;
use App\Http\Controllers\PassengerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\StopController;
use App\Http\Controllers\TripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProfileController::class, 'showDashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/passenger', [PassengerController::class, 'update'])->name('passenger.update');

    Route::middleware('admin.check')->prefix('admin')->group(function () {
        Route::get('/bus', [BusController::class, 'index'])->name('bus.index');
        Route::get('/bus/create', [BusController::class, 'create'])->name('bus.create');
        Route::post('/bus', [BusController::class, 'store'])->name('bus.store');
        Route::get('/bus/{id}', [BusController::class, 'show'])->name('bus.show');

        Route::get('/stop', [StopController::class, 'index'])->name('stop.index');
        Route::get('/stop/create', [StopController::class, 'create'])->name('stop.create');
        Route::post('/stop', [StopController::class, 'store'])->name('stop.store');

        Route::get('/fare', [FareController::class, 'index'])->name('fare.index');
        Route::get('/fare/create', [FareController::class, 'create'])->name('fare.create');
        Route::post('/fare', [FareController::class, 'store'])->name('fare.store');
        Route::get('/fare/{id}/edit', [FareController::class, 'edit'])->name('fare.edit');
        Route::patch('/fare', [FareController::class, 'update'])->name('fare.update');
        Route::get('/fare/{id}', [FareController::class, 'show'])->name('fare.show');

        Route::get('/route', [RouteController::class, 'index'])->name('route.index');
        Route::get('/route/create', [RouteController::class, 'create'])->name('route.create');
        Route::post('/route', [RouteController::class, 'store'])->name('route.store');
        Route::get('/route/{id}', [RouteController::class, 'show'])->name('route.show');

        Route::get('/trip', [JourneyController::class, 'index'])->name('journey.index');
        Route::get('/trip/create', [JourneyController::class, 'create'])->name('journey.create');
        Route::post('/trip', [JourneyController::class, 'store'])->name('journey.store');
        Route::get('/trip/{id}/edit', [JourneyController::class, 'edit'])->name('journey.edit');
        Route::patch('/trip', [JourneyController::class, 'update'])->name('journey.update');
        Route::get('/trip/{id}', [JourneyController::class, 'show'])->name('journey.show');

        Route::get('/all-bookings', [BookingController::class, 'allBookings'])->name('booking.all');
    });
    Route::get('/book-trip/{id}', [BookingController::class, 'bookTrip'])->name('trip.book');
    Route::post('/book-trip', [BookingController::class, 'confirmBooking'])->name('trip.confirm');

    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/upcoming', [BookingController::class, 'upcomingTrips'])->name('booking.upcoming');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::delete('/booking/{id}', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
});

Route::get('/search-trip', [TripController::class, 'searchTrip'])->name('trip.search');

require __DIR__.'/auth.php';
