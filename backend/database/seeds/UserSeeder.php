<?php

use Illuminate\Database\Seeder;
use App\Models\User;

/**
 * Class UserSeeder
 */
class UserSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        User::insert([
            [
                'login' => 'testLogin',
                'password' => bcrypt('testPassword'),
                'email' => 'test@mail.ru',
            ],
            [
                'login' => 'testCreateBookmarkUser',
                'password' => bcrypt('testPassword'),
                'email' => 'testCreateBookmarkUserEmail@mail.com',
            ]
        ]);
    }
}
