<?php

namespace App\Http\Controllers;

use App\Http\Requests\PairRequest;
use App\Models\Convertion;
use Illuminate\Support\Arr;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;

class PairController extends Controller
{

    /**
     * Convert a quantity of currency from an existant pairs
     *
     * @return \Illuminate\Http\Response
     */
    // public function convertCurrencies(Request $request)
    // {
    //     $inputs = $request->all();
       
    //     $pair = Pair::getByID($inputs['pairId']);

    //     if($pair !== null) {
    //         $result = [
    //             'from_price' => round($inputs['price'] * $pair->rate, 2),
    //             'to_price' => round($inputs['price'] / $pair->rate, 2),
    //         ];
        
    //         $pair->convertion()->update(['count' => $pair->count + 1]);

    //         return $this->sendResponse($result, 'Convertion exécuté avec succès.');
    //     }

    //     return $this->sendError('Paire non existante.', null);
    // }

    public function convertCurrencies(Request $request)
    {
        $inputs = $request->all();
       
        $pair = Pair::getByID($inputs['pairId']);

        if($pair->exists()) {

            if($inputs['isReverse']) {
                $result = ['price' => round($inputs['price'] / $pair->rate, 2)];
            } else {
                $result = ['price' => round($inputs['price'] * $pair->rate, 2)];
            }

            $pair->convertion()->increment('count');

            return $this->sendResponse($result, 'Convertion exécuté avec succès.');
        }

        return $this->sendError('Paire non existante.', null);
    }

    /**
     * Convert a quantity of currency from an existant pairs
     *
     * @return \Illuminate\Http\Response
     */
    public function decompte()
    {
        $pairs = Pair::getAll();

        return $this->sendResponse($pairs, 'Pair retrouvé avec succès.');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pairs = Pair::getAll();
        
        if($pairs->isEmpty()) {
            return $this->sendError('La liste des paire est vide.', null); 
        }

        return $this->sendResponse($pairs, 'Liste de paire retrouvé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function show(Pair $pair)
    {
        $result = Pair::getByID($pair->id);

        if($result->exists()){
            dd($result);
        }
        return $this->sendError('Paire non existante.', null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\PairRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PairRequest $request)
    {   
        $inputs = $request->all();
    
        $currencies = Arr::except($inputs, ['rate']);
        
        // Create new entry for currency
        foreach ($currencies as $value) {
            if($value['from']){
                $value['from']['symbol'] = strtoupper($value['from']['symbol']);
                $currencyFrom = Currency::create($value['from']);
            }
            if($value['to']){
                $value['to']['symbol'] = strtoupper($value['to']['symbol']);
                $currencyTo = Currency::create($value['to']);
            }

            // Create new pair
            $pair = Pair::create([
                "rate" => floatval($inputs['rate']),
                "currency_from_id" => $currencyFrom->id,
                "currency_to_id" => $currencyTo->id
            ]);

            $pair->convertion()->create([
                "count" => 0,
                'pair_id' => $pair->id
            ]);

            return $this->sendResponse($pair, 'Pair crée avec succès.');
            
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pair $pair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pair $pair)
    {
        $pair->delete();
        return $this->sendResponse(null, 'Suppression réalisé avec succès.');
    }
}
