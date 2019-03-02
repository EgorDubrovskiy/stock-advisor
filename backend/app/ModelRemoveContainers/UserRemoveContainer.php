<?php

namespace App\ModelRemoveContainers;

use App\Models\User;
use Illuminate\Support\Facades\DB;

/**
 * Class UserRemoveContainer
 * @package App\Models\DeleteContainers
 */
class UserRemoveContainer
{
    /**
     * @param User $user
     * @throws \Throwable
     */
    public function run(User $user) : void
    {
        DB::transaction(function () use ($user) {
            $deleted_at = now();

            $user->deleted_at = $deleted_at;
            $user->save();

            $user->bookmarks()->update(['deleted_at' => $deleted_at]);
        });
    }
}
