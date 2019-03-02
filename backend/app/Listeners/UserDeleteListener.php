<?php

namespace App\Listeners;

use App\Events\UserDeleteEvent;
use Illuminate\Support\Facades\Log;

/**
 * Class UserDeleteEvent
 * @package App\Listeners
 */
class UserDeleteListener
{
    /**
     * Handle the event.
     *
     * @param  UserDeleteEvent  $event
     * @return void
     */
    public function handle(UserDeleteEvent $event)
    {
        Log::channel('deletedUsersLog')->info($event->user);
    }
}
