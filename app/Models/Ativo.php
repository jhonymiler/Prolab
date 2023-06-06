<?php

namespace App\Models;

use App\Helpers\Helper;
use App\Repositories\EnergiaRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use NumberFormatter;

class Ativo extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipamento', 'modelo', 'fabricante', 'ano', 'moeda', 'valor',
        'valor_convertido', 'vida_util', 'potencia', 'horas', 'dias', 'custo_manutencao',
        'custo_pecas', 'afericao', 'depreciacao'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'energia_mes',
        'energia_hora',
        'depreciacao_mes',
        'depreciacao_hora',
        'total'
    ];


    protected function getEnergiaMesAttribute()
    {
        $energia_mes = 0;
        if ($this->potencia > 0) {
            $energia = new EnergiaRepository();
            $energia_mes = (($this->potencia * $this->horas * $this->dias) / 1000) * round($energia->media(), 2);
        }
        return $energia_mes;
    }
    protected function getEnergiaHoraAttribute()
    {
        $energia_hora = 0;
        if ($this->energia_mes > 0) {
            $energia_hora = round($this->energia_mes / 176, 2);
        }
        return $energia_hora;
    }


    protected function getDepreciacaoMesAttribute()
    {
        $valor_vida_util = 0;
        $custo_manutencao_pecas = 0;

        if ($this->valor_convertido > 0 && $this->vida_util) {
            $valor_vida_util = $this->valor_convertido / ($this->vida_util * 12);
        }

        if ($this->custo_manutencao > 0 && $this->custo_pecas > 0) {
            $custo_manutencao_pecas = ($this->custo_manutencao + $this->custo_pecas) / 12;
        }

        return round($valor_vida_util + $custo_manutencao_pecas, 2);
    }

    protected function getDepreciacaoHoraAttribute()
    {
        $depreciacao_hora = 0;
        if ($this->depreciacao_mes > 0) {

            $depreciacao_hora = round($this->depreciacao_mes / 176, 2);
        }
        return $depreciacao_hora;
    }


    protected function getTotalAttribute()
    {
        $total = 0;
        if ($this->energia_hora > 0) {

            $total = round($this->energia_hora + $this->depreciacao_hora, 2);
        }
        return $total;
    }

    protected function setValorAttribute($valor)
    {
        $this->attributes['valor'] = Helper::convertDecimal($valor);
    }
}
