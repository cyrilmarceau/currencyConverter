<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'name',
        'symbol'
    ];

    /**
     * getAll
     * Get a list of all currencies
     * @return Collection
     */
    public static function getAll(): Collection
    {
        $currencies = Currency::all();

        return $currencies;
    }

    /**
     * getBySymbol
     * Get a list of all currencies
     * @return array
     */
    public static function getBySymbol(string $currencyFromSymbol , string $currencyToSymbol)
    {
        $idFrom = Currency::where('symbol', $currencyFromSymbol)->first();
        $idTo = Currency::where('symbol', $currencyToSymbol)->first();
        
        $result = [
            'idFrom' => $idFrom->id,
            'idTo' => $idTo->id
        ];

        return (object) $result;
    }
}
