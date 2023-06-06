<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Medidas;
use App\Models\Entregaveis;

class EntregaveisController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Cadastros"], ['name' => "Entregaveis"]];

        $entregaveis = Entregaveis::orderBy('descricao')->get();

        //dd($materiais->toArray());
        $unidade = Medidas::orderBy('tipo', 'asc')
            ->orderBy('nome', 'asc')
            ->get();

        return view('cadastros/entregaveis', [
            'breadcrumbs' => $breadcrumbs,
            'entregaveis' => $entregaveis,
            'unidades' => $unidade
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'descricao' => 'required',
           
            'medida_id' => 'required', 
        ]);

        if ($id == 0) {
            $entregavel = new Entregaveis();
        } else {
            $entregavel = Entregaveis::where('id', $id);
            if (!$entregavel->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $entregavel = $entregavel->first();
            }
        }

        $entregavel->descricao = $request->descricao;
        $entregavel->medida_id = $request->medida_id;
        $entregavel->valor = $request->valor;
        $entregavel->observacao = $request->observacao;

        if ($entregavel->save()) {
            return \redirect('/entregavel')->with([
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
        $entregavel = Entregaveis::where('id', $id);
        if (!$entregavel->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $entregavel = $entregavel->first();
            $entregavel->status = !$entregavel->status;
            if ($entregavel->save()) {
                return \redirect('/entregavel')->with([
                    'sucesso' => ($entregavel->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
