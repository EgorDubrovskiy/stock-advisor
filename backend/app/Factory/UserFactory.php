<?php

namespace App\Factory;

use App\Models\User;

/**
 * Class UserFactory
 * @package App\Factory
 */
class UserFactory
{
    /**
     * @return User
     */
    public function makeUser() : User
    {
        return new User();
    }
}
