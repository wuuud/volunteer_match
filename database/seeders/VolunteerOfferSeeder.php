<?php

namespace Database\Seeders;

use App\Models\Npo;
use App\Models\VolunteerOffer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VolunteerOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $npos = Npo::take(4)->get();
        foreach ($npos as $npo) {
            // 期限切れ且つ募集終了(期限昨日)
            VolunteerOffer::create([
                'npo_id' => $npo->id,
                'title' => $npo->name . 'でのボランティア募集 1 のタイトル',
                'description' => $npo->name . 'でのボランティア募集 1 の詳細',
                'start_date' => Carbon::yesterday()->toDateString(),
                'is_published' => 0,
            ]);
            // 募集終了(期限翌月)
            VolunteerOffer::create([
                'npo_id' => $npo->id,
                'title' => $npo->name . 'でのボランティア募集 2 のタイトル',
                'description' => $npo->name . 'でのボランティア募集 2 の詳細',
                'start_date' => Carbon::now()->firstOfMonth()->addMonth(1)->toDateString(),
                'is_published' => 0,
            ]);
            // 募集中(期限翌月)
            VolunteerOffer::create([
                'npo_id' => $npo->id,
                'title' => $npo->name . 'でのボランティア募集 3 のタイトル',
                'description' => $npo->name . 'でのボランティア募集 3 の詳細',
                'start_date' => Carbon::now()->firstOfMonth()->addMonth(1)->toDateString(),
            ]);
            // 募集中(期限翌々月)
            VolunteerOffer::create([
                'npo_id' => $npo->id,
                'title' => $npo->name . 'でのボランティア募集 4 のタイトル',
                'description' => $npo->name . 'でのボランティア募集 4 の詳細',
                'start_date' => Carbon::now()->firstOfMonth()->addMonth(2)->toDateString(),
            ]);
        }
    }
}
