<?php

namespace App\Http\Controllers;

use App\Models\Energia;
use App\Repositories\EnergiaRepository;
use Illuminate\Http\Request;

class EnergiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['name' => "Controle de Energia"]];

        $model = new EnergiaRepository();
        $lancamentos = $model->all();

        // media 6 meses
        $dadosGrafico = $model->shortDataLastPeriod();
        $graficoMes = json_encode($dadosGrafico['mes']);
        $graficoDados = json_encode($dadosGrafico['dados']);

        // completo 1 ano
        $dadosGrafico_completo = $model->shortDataLastPeriod(12, 0);
        $graficoMes_completo = json_encode($dadosGrafico_completo['mes']);
        $graficoDados_completo = json_encode($dadosGrafico_completo['dados']);


        return view('cadastros/energia', [
            'breadcrumbs' => $breadcrumbs,
            'lancamentos' => $lancamentos,
            'media' => $model->media(),
            'diff_media' => $model->diffMedia(),
            'graficoMes' => $graficoMes,
            'graficoDados' => $graficoDados,
            'graficoCompleto' => [
                'mes' => $graficoMes_completo,
                'dados' => $graficoDados_completo
            ]
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'data' => 'required',
            'consumo' => 'required',
            'valor' => 'required',
        ]);

        if ($id == 0) {
            $energia = new Energia();
        } else {
            $energia = Energia::where('id', $id);
            if (!$energia->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $energia = $energia->first();
            }
        }
        $campoData = explode('/', $request->data);
        $data = "$campoData[1]-$campoData[0]-01";
        $energia->data = $data;
        $energia->consumo = $request->consumo;
        $energia->valor = $request->valor;

        if ($energia->save()) {
            return \redirect('/custo-energia')->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Houve um erro, os dados não puderam ser salvos!'
            ]);
        }
    }
}
