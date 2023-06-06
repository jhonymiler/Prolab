<?php

namespace App\Http\Controllers;

use App\Models\CustoCondominio;
use Illuminate\Http\Request;
use App\Models\Medidas;

class CustoCondominioController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Cadastros"], ['name' => "Custos Condominios"]];

        $operacional = CustoCondominio::orderBy('descricao')->get();

        //dd($materiais->toArray());
        $unidade = Medidas::orderBy('tipo', 'asc')
            ->orderBy('nome', 'asc')
            ->get();

        return view('cadastros/condominios', [
            'breadcrumbs' => $breadcrumbs,
            'dados' => $operacional,
            'unidades' => $unidade
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'descricao' => 'required',
            'valor' => 'required',
            'medida_id' => 'required', 
        ]);

        if ($id == 0) {
            $operacional = new CustoCondominio();
        } else {
            $operacional = CustoCondominio::where('id', $id);
            if (!$operacional->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $operacional = $operacional->first();
            }
        }

        $operacional->descricao = $request->descricao;
        $operacional->medida_id = $request->medida_id;
        $operacional->valor = $request->valor;
        $operacional->observacao = $request->observacao;

        if ($operacional->save()) {
            return \redirect('/custo-condominio')->with([
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
        $operacional = CustoCondominio::where('id', $id);
        if (!$operacional->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $operacional = $operacional->first();
            $operacional->status = !$operacional->status;
            if ($operacional->save()) {
                return \redirect('/custo-condominio')->with([
                    'sucesso' => ($operacional->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
