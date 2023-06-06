<?php

namespace App\Models;

use Attribute;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Profissional extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cargo',
        'valor_mercado',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'proxima_atualizacao'
    ];

    protected $table = 'profissionais';

    protected $appends = [
        'encargos',
        'custo_mes',
        'custo_hora',
        'proxima_atualizacao'
    ];

    protected function getProximaAtualizacaoAttribute()
    {
        // Data de ínicio
        $date    = (new DateTime($this->updated_at));
        // Adiciona 1 mês a data
        $newDate = $date->add(new DateInterval('P1M'));
        // Altera a nova data para o último dia do mês
        $lDayOfMonth = $newDate->modify('last day of this month');
        return $lDayOfMonth->format('d/m/Y'); // 2017-12-31
    }



    protected function getCustoHoraAttribute()
    {
        return $this->custo_mes / 176;
    }


    protected function getCustoMesAttribute()
    {
        return $this->valor_mercado + $this->encargos;
    }


    protected function getEncargosAttribute()
    {
        return $this->valor_mercado * 0.67;
    }

    protected function setValorMercadoAttribute($valor)
    {
        $num = preg_replace('/[^0-9\.\,]/', '', $valor);
        $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
        $num = $fmt->parse($num);
        $this->attributes['valor_mercado'] = $num;
    }

    // protected static function convertToDecimal($valor)
    // {
    //     $fmt = new NumberFormatter('de_DE', NumberFormatter::DECIMAL);
    //     $valor = $fmt->parse($valor);
    //     return $valor;
    // }
}
