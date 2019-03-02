<?php

namespace App\Providers;

use App\Events\UserUpdatedEvent;
use App\Events\UserDeleteEvent;
use App\Events\ResetPasswordEvent;
use App\Events\SaveAvatarEvent;
use App\Events\CriticalLogEvent;
use App\Events\EmergencyLogEvent;
use App\Events\ValidateRegistrationEvent;
use App\Listeners\ValidateRegistrationListener;
use App\Listeners\CriticalLogListener;
use App\Listeners\EmergencyLogListener;
use App\Listeners\SaveAvatarListener;
use App\Listeners\UserDeleteListener;
use App\Listeners\SendUpdatedInfo;
use App\Listeners\ResetPasswordListener;
use App\Events\BookmarkInserted;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserUpdatedEvent::class => [
            SendUpdatedInfo::class,
            ],
        BookmarkInserted::class => [
            BookmarkInserted::class,
        ],
        UserDeleteEvent::class => [
            UserDeleteListener::class,
        ],
        ResetPasswordEvent::class => [
            ResetPasswordListener::class,
        ],
        SaveAvatarEvent::class => [
            SaveAvatarListener::class,
        ],
        EmergencyLogEvent::class => [
            EmergencyLogListener::class,
        ],
        CriticalLogEvent::class => [
            CriticalLogListener::class,
        ],
        ValidateRegistrationEvent::class => [
            ValidateRegistrationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
