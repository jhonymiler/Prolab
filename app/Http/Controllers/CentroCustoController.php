<?php

namespace App\Http\Controllers;

use App\Models\CentroCusto;
use Illuminate\Http\Request;

class CentroCustoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Configurações"], ['name' => "Centro de Custo"]];

        $cc = CentroCusto::all();

        return view('config/centro-custo/index', [
            'breadcrumbs' => $breadcrumbs,
            'cc' => $cc
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        if ($id == 0) {
            $centrocusto = new CentroCusto();
        } else {
            $centrocusto = CentroCusto::where('id', $id);
            if (!$centrocusto->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $centrocusto = $centrocusto->first();
            }
        }

        $centrocusto->nome = $request->nome;
        if ($centrocusto->save()) {
            return \redirect('/config/centro-custo')->with([
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
        $centrocusto = CentroCusto::where('id', $id);
        if (!$centrocusto->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $cc = $centrocusto->first();
            $cc->status = !$cc->status;
            if ($cc->save()) {
                return \redirect('/config/centro-custo')->with([
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
