<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pair extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'created_at',
        'updated_at',
        'rate',
        'currency_from_id',
        'currency_to_id'
    ];


    /**
     * getAll
     * Get a list of all pairs
     * @return array
     */
    public static function getAll()
    {
        $pairs = Pair::all();
        return $pairs;
    }
}
