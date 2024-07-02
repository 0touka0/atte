<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'テスト',
            'email' => 'test@example.com',
            'password' => Hash::make('testexample')
            ];
            DB::table('users')->insert($param);

        User::Factory()->count(30)->create();
    }
}
