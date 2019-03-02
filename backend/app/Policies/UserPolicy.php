<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserPolicy
 * @package App\Policies
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     */
    public function getBookmarks(User $user) : bool
    {
        return Auth::id() === $user->id;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function delete(User $user) : bool
    {
        return Auth::id() === $user->id;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function readInfo(User $user) : bool
    {
        return Auth::id() === $user->id;
    }
}
