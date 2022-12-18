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
        \App\Models\User::factory(10)->create();
        \App\Models\Npo::factory(10)->create();
        \App\Models\Volunteer::factory(10)->create();
        // \App\Models\Message::factory(10)->create();
        $this->call(VolunteerOfferSeeder::class);
        $this->call(ApplicationSeeder::class);
        // $this->call(ProposeSeeder::class);
    }
}
