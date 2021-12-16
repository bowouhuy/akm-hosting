<?php

namespace Database\Seeders;

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
        DB::table('users')->insert([
            [
                'username' => 'yonisaka',
                'first_name' => 'Yoni',
                'last_name' => 'Saka',
                'email' => 'yonisaka@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
