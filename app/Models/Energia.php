<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Energia extends Model
{
    use HasFactory;
    protected $fillable = [
        'consumo',
        'valor',
        'data'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'data'
    ];

    protected $appends = [
        'valor_kw',
    ];

    protected function setValorAttribute($valor)
    {

        $this->attributes['valor'] = Helper::convertDecimal($valor);
    }

    protected function getValorKwAttribute()
    {
        return round($this->valor / $this->consumo, 2);
    }
}
