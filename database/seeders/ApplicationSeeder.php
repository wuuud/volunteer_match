<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Application;
use App\Models\User;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::take(10)->get();
        foreach ($users as $user) {
            Application::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'career' => $user->name . 'が行いたいこと', 
            ]);
        }
    }
}
