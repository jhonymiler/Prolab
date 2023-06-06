<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materiais extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'valor', 'medida_id', 'status', 'observacao'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function medida()
    {
        return $this->hasOne(Medidas::class, 'id', 'medida_id');
    }
    protected function setValorAttribute($valor)
    {

        $this->attributes['valor'] = Helper::convertDecimal($valor);
    }
}
