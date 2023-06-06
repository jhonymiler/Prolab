<?php

namespace App\Http\Controllers;

use App\Models\Fundacao;
use Illuminate\Http\Request;

class FundacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Configurações"], ['name' => "Fundações"]];

        $fund = Fundacao::all();

        return view('config/fundacao/index', [
            'breadcrumbs' => $breadcrumbs,
            'fund' => $fund
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        if ($id == 0) {
            $fundacao = new Fundacao();
        } else {
            $fundacao = Fundacao::where('id', $id);
            if (!$fundacao->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $fundacao = $fundacao->first();
            }
        }

        $fundacao->nome = $request->nome;
        if ($fundacao->save()) {
            return \redirect('/config/fundacao')->with([
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
        $fundacao = Fundacao::where('id', $id);
        if (!$fundacao->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $fund = $fundacao->first();
            $fund->status = !$fund->status;
            if ($fund->save()) {
                return \redirect('/config/fundacao')->with([
                    'sucesso' => ($fund->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
