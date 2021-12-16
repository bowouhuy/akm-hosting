<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('question_types')->insert([
            [
                'name' => 'Numerasi',
            ],
            [
                'name' => 'Literasi Teks Fiksi',
            ],
            [
                'name' => 'Literasi Teks Informasi',
            ]
        ]);
    }
}
