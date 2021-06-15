<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("program_languages")->insert([
            LanguageTableSeeder::data(0, "Plain Text"),
            LanguageTableSeeder::data(1, "C"),
            LanguageTableSeeder::data(2, "C++"),
        ]);
    }

    private function data($id, $language): array
    {
        return [
            "program_language_id" => $id,
            "language_name" => $language
        ];
    }
}
