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
        $volunteers = Volunteer::take(4)->get();
        foreach ($volunteers as $volunteer) {
            Application::create([
                'volunteer_id' => $volunteer->id,
                'volunteer_name' => '希望者氏名' . $volunteer->name,
                'volunteer_profile' => 'ボランティア希望内容(profile)' . $volunteer->profile,
            ]);
        }
    }
}
