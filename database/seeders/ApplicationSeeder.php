<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Application;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $volunteers = Volunteer::take(10)->get();
        foreach ($volunteers as $volunteer) {
            Application::create([
                'volunteer_id' => $volunteer->id,
                'career' => $volunteer->user->name . 'が行いたいこと', 
            ]);
        }
    }
}
