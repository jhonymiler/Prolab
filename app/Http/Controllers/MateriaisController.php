<?php

namespace App\Http\Controllers;

use App\Models\Materiais;
use App\Models\Medidas;
use Illuminate\Http\Request;

class MateriaisController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Cadastros"], ['name' => "Materiais de Uso e Consumo"]];

        $materiais = Materiais::orderBy('nome')->get();

        //dd($materiais->toArray());
        $unidade = Medidas::orderBy('tipo', 'asc')
            ->orderBy('nome', 'asc')
            ->get();

        return view('cadastros/materiais', [
            'breadcrumbs' => $breadcrumbs,
            'materiais' => $materiais,
            'unidades' => $unidade
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'nome' => 'required',
            'valor' => 'required',
            'medida_id' => 'required',
        ]);

        if ($id == 0) {
            $materiais = new Materiais();
        } else {
            $materiais = Materiais::where('id', $id);
            if (!$materiais->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $materiais = $materiais->first();
            }
        }

        $materiais->nome = $request->nome;
        $materiais->medida_id = $request->medida_id;
        $materiais->valor = $request->valor;
        $materiais->observacao = $request->observacao;
        
        if ($materiais->save()) {
            return \redirect('/materiais')->with([
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
        $materiais = Materiais::where('id', $id);
        if (!$materiais->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $materiais = $materiais->first();
            $materiais->status = !$materiais->status;
            if ($materiais->save()) {
                return \redirect('/materiais')->with([
                    'sucesso' => ($materiais->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
