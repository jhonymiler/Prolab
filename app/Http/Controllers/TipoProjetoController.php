<?php

namespace App\Http\Controllers;

use App\Models\TipoProjeto;
use Illuminate\Http\Request;

class TipoProjetoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Configurações"], ['name' => "Tipo de Projeto"]];

        $tipos = TipoProjeto::all();

        return view('config/tipo-projeto/index', [
            'breadcrumbs' => $breadcrumbs,
            'tipos' => $tipos
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        if ($id == 0) {
            $tipoprojeto = new TipoProjeto();
        } else {
            $tipoprojeto = TipoProjeto::where('id', $id);
            if (!$tipoprojeto->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $tipoprojeto = $tipoprojeto->first();
            }
        }

        $tipoprojeto->nome = $request->nome;
        if ($tipoprojeto->save()) {
            return \redirect('/config/tipo-projeto')->with([
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
        $tipoprojeto = TipoProjeto::where('id', $id);
        if (!$tipoprojeto->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $fund = $tipoprojeto->first();
            $fund->status = !$fund->status;
            if ($fund->save()) {
                return \redirect('/config/tipo-projeto')->with([
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
