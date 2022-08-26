<?php

namespace App\Models;

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
     * @return array
     */
    public static function getAll()
    {
        $currencies = Currency::all();

        return $currencies;
    }
}
