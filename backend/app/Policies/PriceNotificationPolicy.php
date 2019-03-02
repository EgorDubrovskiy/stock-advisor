<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PriceNotification;
use Illuminate\Auth\Access\HandlesAuthorization;

class PriceNotificationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create price notifications.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id === Auth()->id();
    }

    /**
     * Determine whether the user can update the price notification.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PriceNotification  $priceNotification
     * @return mixed
     */
    public function update(User $user, PriceNotification $priceNotification)
    {
        return $priceNotification->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the price notification.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PriceNotification  $priceNotification
     * @return mixed
     */
    public function delete(User $user, PriceNotification $priceNotification)
    {
        return $priceNotification->user_id === $user->id;
    }

    /**
     * Determine whether the user can get the price notification data.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\PriceNotification  $priceNotification
     * @return mixed
     */
    public function get(User $user, PriceNotification $priceNotification)
    {
        return $priceNotification->user_id === $user->id;
    }
}
