<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('packages')->insert([
            [
                'name' => 'Paket 1',
                'description' => 'Kelas 7 dan Kelas 8',
                'price' => 40000,
            ],
            [
                'name' => 'Paket 2',
                'description' => 'Kelas 9',
                'price' => 60000,
            ]
        ]);
    }
}
