<?php

namespace Database\Seeders;

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
        
        // for($i = 0; $i < count($currencies); $i++) {

            foreach($currencies as $currency) {

                // if($currency->id !== $currencies[$i]->id) {

                    Pair::create([
                        "rate" => mt_rand(0.1*10, 1.5*10) / 10,
                        "currency_from_id" => rand(1, count($currencies)),
                        "currency_to_id" => $currency->id
                    ]);
                // }
    
            }

        // }
    }
}
