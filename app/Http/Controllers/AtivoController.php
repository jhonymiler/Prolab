<?php

namespace App\Http\Controllers;

use App\Models\Ativo;
use Illuminate\Http\Request;

class AtivoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['name' => "Controle de Ativos"]];

        $ativos = Ativo::all();

        return view('cadastros/ativos', [
            'breadcrumbs' => $breadcrumbs,
            'ativos' => $ativos
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'equipamento' => 'required',
            'valor' => 'required_without:potencia',
            'potencia' => 'required_without:valor',
            'vida_util' => 'required_with:valor',
        ]);

        if ($id == 0) {
            $ativo = new Ativo();
        } else {
            $ativo = Ativo::where('id', $id);
            if (!$ativo->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $ativo = $ativo->first();
            }
        }


        $ativo->equipamento         = $request->equipamento;
        $ativo->modelo              = $request->modelo;
        $ativo->fabricante          = $request->fabricante;
        $ativo->ano                 = $request->ano;
        $ativo->moeda               = $request->moeda;
        $ativo->sigla               = $request->sigla;
        $ativo->valor               = $request->valor;
        $ativo->valor_convertido    = $request->valor_convertido;
        $ativo->vida_util           = $request->vida_util;
        $ativo->potencia            = $request->potencia;
        $ativo->horas               = $request->horas;
        $ativo->dias                = $request->dias;
        $ativo->custo_manutencao    = $request->custo_manutencao;
        $ativo->custo_pecas         = $request->custo_pecas;
        $ativo->afericao            = $request->afericao;
        $ativo->depreciacao         = $request->depreciacao;

        if ($ativo->save()) {
            return \redirect('/ativos')->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Houve um erro, os dados não puderam ser salvos!'
            ]);
        }
    }

    public function ativa_desativa(int $id)
    {
        $ativos = Ativo::where('id', $id);
        if (!$ativos->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $cc = $ativos->first();
            $cc->status = !$cc->status;
            if ($cc->save()) {
                return \redirect('/ativos')->with([
                    'sucesso' => ($cc->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
