<?php

namespace App\Http\Controllers;

use App\Models\CustoOperacional;
use App\Models\Medidas;
use Illuminate\Http\Request;

class CustoOperacionalController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/", 'name' => "Cadastros"], ['name' => "Custos Operacionais"]];

        $operacional = CustoOperacional::orderBy('descricao')->get();

        //dd($materiais->toArray());
        $unidade = Medidas::orderBy('tipo', 'asc')
            ->orderBy('nome', 'asc')
            ->get();

        return view('cadastros/operacionais', [
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
            $operacional = new CustoOperacional();
        } else {
            $operacional = CustoOperacional::where('id', $id);
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
            return \redirect('/custo-operacional')->with([
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
        $operacional = CustoOperacional::where('id', $id);
        if (!$operacional->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $operacional = $operacional->first();
            $operacional->status = !$operacional->status;
            if ($operacional->save()) {
                return \redirect('/custo-operacional')->with([
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
