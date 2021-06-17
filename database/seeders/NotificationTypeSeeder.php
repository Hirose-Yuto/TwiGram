<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("notification_types")->insert([
            NotificationTypeSeeder::data(1, "like"),
            NotificationTypeSeeder::data(2, "mention"),
            NotificationTypeSeeder::data(3, "retwig_with_comment"),
            NotificationTypeSeeder::data(4, "reply"),
            NotificationTypeSeeder::data(5, "follow"),
        ]);
    }

    private function data($id, $notification_type): array
    {
        return [
            "notification_type_id" => $id,
            "notification_type" => $notification_type
        ];
    }
}
