<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * Class SaveAvatarEvent
 * @package App\Events
 */
class SaveAvatarEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var string $avatar
     */
    public $avatar;

    /**
     * SaveAvatarEvent constructor.
     * @param string $avatar
     */
    public function __construct(string $avatar)
    {
        $this->avatar = $avatar;
    }
}
