<?php

namespace App\Http\Controllers;

use Throwable;

use App\Http\Requests\ConvertCurrencyRequest;
use App\Http\Requests\PairRequest;
use App\Models\Convertion;
use Illuminate\Support\Arr;
use App\Models\Currency;
use App\Models\Pair;
use Illuminate\Http\Request;

class PairController extends Controller
{

    /**
     * Convert currencies and increment pair associate to the currency
     */
    public function convertCurrencies(ConvertCurrencyRequest $request)
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

            return $this->sendResponse($result, 'Conversion exécutée avec succès.');
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

        return $this->sendResponse($pairs, 'Paire retrouvé avec succès.');

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
        } else {
            return $this->sendResponse($pairs, 'Liste de paire retrouvé avec succès.');
        }

        
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
             return $this->sendResponse($result, 'Liste de paire retrouvé avec succès.');
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
        
        if($inputs['currencies']['from']){
            $inputs['currencies']['from']['symbol'] = strtoupper($inputs['currencies']['from']['symbol']);
            $currencyFrom = Currency::create($inputs['currencies']['from']);
        }

        if($inputs['currencies']['to']){
            $inputs['currencies']['to']['symbol'] = strtoupper($inputs['currencies']['to']['symbol']);
            $currencyTo = Currency::create($inputs['currencies']['to']);
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

        return $this->sendResponse($pair, 'Paire crée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PairRequest  $request
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function update(PairRequest $request, Pair $pair)
    {
        $inputs = $request->all();
    
        $currencies = Arr::except($inputs, ['rate']);

        $pair->update(['rate' => $inputs['rate']]);


        // Create new entry for currency
        foreach ($currencies as $value) {
            if($value['from']){
                $value['from']['symbol'] = strtoupper($value['from']['symbol']);

                $pair->currency_from_id()->update(['name' =>  $value['from']['name']]);
                $pair->currency_from_id()->update(['symbol' =>  $value['from']['symbol']]);
            }
            if($value['to']){
                $value['to']['symbol'] = strtoupper($value['to']['symbol']);
                $pair->currency_to_id()->update(['name' =>  $value['to']['name']]);
                $pair->currency_to_id()->update(['symbol' =>  $value['to']['symbol']]);
            }

            return $this->sendResponse($pair, 'Paire mise à jours avec succès.');
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pair $pair)
    {
        $toto = $pair->delete();
        return $this->sendError('La liste des paire est vide.', $toto); 
    }
}
