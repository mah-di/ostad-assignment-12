<?php

namespace App\Providers;

use App\Events\BookingCancelled;
use App\Events\JourneyCreated;
use App\Events\BookingMade;
use App\Events\TripCreated;
use App\Listeners\AvailSeats;
use App\Listeners\CreateSeats;
use App\Listeners\CreateTrips;
use App\Listeners\UpdateSeats;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        JourneyCreated::class => [
            CreateTrips::class,
        ],
        TripCreated::class => [
            CreateSeats::class,
        ],
        BookingMade::class => [
            UpdateSeats::class,
        ],
        BookingCancelled::class => [
            AvailSeats::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
