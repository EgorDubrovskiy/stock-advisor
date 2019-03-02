<?php

use Illuminate\Database\Seeder;
use App\Models\{User, Company};

class BookmarkSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $user = User::where('email', 'test@mail.ru')->first();
            $company = Company::where('symbol', 'IBM')->first();
            $user->companies()->attach($company);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
