<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\{User, Company};

/**
 * Class BookmarkInserted
 * @package App\Events
 * @property User $user
 * @property Company $company
 */
class BookmarkInserted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var User $user */
    public $user;

    /** @var Company $company */
    public $company;

    /**
     * BookmarkInserted constructor.
     * @param User $user
     * @param Company $company
     */
    public function __construct(User $user, Company $company)
    {
        $this->user = $user;
        $this->company = $company;
    }

    public function handle() {

    }
}
