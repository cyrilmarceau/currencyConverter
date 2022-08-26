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
     * IMPORTANT A LIRE concernant la relation de la paire et des devises
     * La relation est créer depuis un Provider afin de pouvoir liée 2 champ à 1 clé primaire
     * Voir fichier App/Provider/AppServiceProvider -> fonction boot
     */

    // Relation between convertion and pair
    public function convertion(){
        return $this->hasOne(Convertion::class);
    }


    /**
     * getAll
     * Get a list of all pairs
     */
    public static function getAll()
    {
        $pairs = Pair::with(['currency_from_id', 'currency_to_id', 'convertion'])->get();

        return $pairs;
    }

    /**
     * getByID
     * Get pair by ID
     * @return object
     */
    public static function getByID(int $id): object
    {
        $pair = Pair::with(['currency_from_id', 'currency_to_id'])->findOrFail($id);
        return $pair;
    }

    /**
     * getByID
     * Get pair by ID
     * @return object
     */
    public static function getByCurrenciesID(int $currency_from, int $currency_to)
    {
        $pair = Pair::where('currency_from_id', $currency_from)->where('currency_to_id', $currency_to)->first();
        return $pair;
    }
}
