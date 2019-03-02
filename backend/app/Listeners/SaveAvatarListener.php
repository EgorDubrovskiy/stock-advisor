<?php

namespace App\Listeners;

use App\Events\SaveAvatarEvent;
use App\Jobs\CropAvatarJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SaveAvatarListener
 * @package App\Listeners
 */
class SaveAvatarListener
{
    /**
     * Handle the event.
     *
     * @param  SaveAvatarEvent  $event
     * @return void
     */
    public function handle(SaveAvatarEvent $event)
    {
        CropAvatarJob::dispatch($event->avatar);
    }
}
