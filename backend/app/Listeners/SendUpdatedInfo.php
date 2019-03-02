<?php

namespace App\Listeners;

use App\Events\UserUpdatedEvent;
use App\Jobs\UpdateUser;

/**
 * Class SendUpdatedInfo
 * @package App\Listeners
 */
class SendUpdatedInfo
{
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserUpdatedEvent  $event
     * @return void
     */
    public function handle(UserUpdatedEvent $event)
    {
        UpdateUser::dispatch($event->user);
    }
}
