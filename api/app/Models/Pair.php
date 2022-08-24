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

    // Relation between convertion and pair
    public function convertion(){
        return $this->hasOne(Convertion::class);
    }


    /**
     * getAll
     * Get a list of all pairs
     * @return array
     */
    public static function getAll()
    {
        $pairs = Pair::with(['currency_from_id', 'currency_to_id'])->get();

        return $pairs;
    }

    /**
     * getByID
     * Get pair by ID
     * @return array
     */
    public static function getByID(int $id): object
    {
        $pair = Pair::find($id);
        return $pair;
    }

    /**
     * getByID
     * Get pair by ID
     * @return array
     */
    public static function getByCurrenciesID(int $currency_from, int $currency_to)
    {
        $pair = Pair::where('currency_from_id', $currency_from)->where('currency_to_id', $currency_to)->first();
        return $pair;
    }
}
