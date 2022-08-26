<?php

namespace App\Http\Controllers;

use Throwable;

use App\Http\Requests\ConvertCurrencyRequest;
use App\Http\Requests\PairCreateRequest;
use App\Http\Requests\PairUpdateRequest;
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
     * @param  \Illuminate\Http\PairCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PairCreateRequest $request)
    {   
        $isPairExist = Pair::getByCurrenciesID($request->all()['currency_from_id'], $request->all()['currency_to_id']);
        
        if($isPairExist !== null){
            return $this->sendError('La paire existe déjà.', null, 409);
        }

        $pair = Pair::create($request->all());

        $pair->convertion()->create([
            "count" => 0,
            'pair_id' => $pair->id
        ]);

        return $this->sendResponse($pair, 'Paire crée avec succès.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\PairUpdateRequest  $request
     * @param  \App\Models\Pair  $pair
     * @return \Illuminate\Http\Response
     */
    public function update(PairUpdateRequest $request, Pair $pair)
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
        $pair->delete();
        return $this->sendResponse(null, 'La paire a bien été supprimer.'); 
    }
}
