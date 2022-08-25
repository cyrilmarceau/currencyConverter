<?php

namespace Database\Seeders;

use App\Models\Convertion;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = Currency::all();
        
        foreach($currencies as $key => $currency) {

            $pair = Pair::create([
                "rate" => mt_rand(0.1 * 10, 1.5 *10) / 10.3,
                "currency_from_id" => rand(1, count($currencies)),
                "currency_to_id" => $currency->id
            ]);

            Convertion::create([
                "count" => rand(0, 5),
                'pair_id' => $pair->id
            ]);

        }
    }
}
