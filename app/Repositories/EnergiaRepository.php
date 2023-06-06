<?php

namespace App\Repositories;

use App\Models\Energia;
use Illuminate\Support\Facades\DB;
use stdClass;

class EnergiaRepository extends BaseRepository
{
    protected $model = Energia::class;
    public function listPeriod($meses = 6, $a_partir = 0)
    {
        $intervalo_ini = $meses + $a_partir;
        $intervalo_fim = $a_partir == 0 ? strtotime('today') : strtotime('-' . $a_partir . ' month');

        $dateOld = date('Y-m', strtotime('-' . $intervalo_ini . ' month')) . '-01';
        $date = date('Y-m', $intervalo_fim) . '-01';

        return $this->model->whereBetween(DB::raw('DATE(data)'), [$dateOld, $date])->get();
    }

    public function media($meses = 6, $a_partir = 0)
    {
        $energias = $this->listPeriod($meses, $a_partir);

        $qtdRegistros = count($energias);
        $soma = 0;
        foreach ($energias as $energia) {
            $soma += $energia->valor_kw;
        }
        if ($qtdRegistros > 0) {
            return $soma / $qtdRegistros;
        } else {
            return 0;
        }
    }


    public function shortDataLastPeriod($meses = 6, $a_partir = 0)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Sao_Paulo');

        $dados = $this->listPeriod($meses, $a_partir);
        $shortData = [];
        foreach ($dados as $key => $value) {
            $shortData['mes'][$key] = strftime('%b', strtotime($value->data));
            $shortData['dados'][$key] = $value->valor_kw;
        }

        return $shortData;
    }

    public function diffMedia()
    {
        $media1 = $this->media(6, 6);
        $media2 = $this->media();

        $dif = $media1 - $media2;
        if ($dif > 0) {
            $queda = true;
            $perc = 100 - ($media2 * 100 / $media1);
        } elseif ($dif == 0) {
            $queda = false;
            $perc = 0;
        } else {
            $queda = false;
            $perc = 100 - ($media1 * 100 / $media2);
        }
        return [
            'queda' => $queda,
            'perc' => round($perc, 2) . '%'
        ];
    }
}
