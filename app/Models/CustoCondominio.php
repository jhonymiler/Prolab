<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustoCondominio extends Model
{
    use HasFactory;

    protected $table = 'custo_condominios';

     // campos editaveis
    protected $fillable = [
        'descricao', 'valor', 'medida_id', 'status','observacao'
    ];
    // campos 
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
