<?php

namespace App\Services\Models;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Factory\UserFactory;

/**
 * Class UserService
 * @package App\Services\Models
 */
class UserService
{
    /**
     * @var UserFactory
     */
    protected $user;

    /**
     * UserService constructor.
     * @param UserFactory $user
     */
    public function __construct(UserFactory $user)
    {
        $this->user = $user;
    }

    /**
     * @param array $fields
     * @return User
     */
    public function create(array $fields): User
    {
        $user = $this->user->makeUser();
        $user->login = $fields['login'];
        $user->password = Hash::make($fields['password'], ['rounds' => 12]);
        $user->email = $fields['email'];
        $user->activation_token = str_random(60);
        $user->save();

        return $user;
    }

    /**
     * @param User $user
     * @param array $newFields
     * @return User
     */
    public function update(User $user, array $newFields): User
    {
        $user->update($newFields);
        if (array_key_exists('password', $newFields)) {
            $user->password = Hash::make($newFields['password'], ['rounds' => 12]);
            $user->save();
        }

        return $user;
    }
}
