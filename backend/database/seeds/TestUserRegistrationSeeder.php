<?php

use Illuminate\Database\Seeder;

class TestUserRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login' => 'testlogin',
            'email' => 'testemail@gmail.com',
            'password' => bcrypt('testtest'),
        ]);
    }
}
