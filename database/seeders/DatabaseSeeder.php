<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ConstantTableSeeder::class,
            DirectMessageSeeder::class,
            FollowFollowedRelationshipTableSeeder::class,
            LanguageTableSeeder::class,
            NotificationSeeder::class,
            NotificationTypeSeeder::class,
            TwigTableSeeder::class,
            UsersLikesSeeder::class,
            UsersTwigsOwnershipSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
