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

    public function currenciesFrom()
    {
        $this->resolveRelationUsing('currency', function ($currencyModel) {
            return $currencyModel->belongsTo(Currency::class, 'currency_from_id');
        });
    }

    public function currenciesTo()
    {
        $this->resolveRelationUsing('currency', function ($currencyModel) {
            return $currencyModel->belongsTo(Currency::class, 'currency_to_id');
        });
    }

    public function currencies()
    {
        return $this->belongsTo(Currencies::class);
    }
}
