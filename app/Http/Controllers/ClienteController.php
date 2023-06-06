<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"],  ['name' => "Clientes"]];

        $clientes = Cliente::all();

        return view('cadastros/clientes', [
            'breadcrumbs' => $breadcrumbs,
            'clientes' => $clientes
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'razao_social' => 'required',
            'nome_fantasia' => 'required',
            'cnpj' => 'required',
            'telefone' => 'required',
            'celular' => 'required',
            'email' => 'required',
            'responsavel' => 'required',
            'ie' => 'required',
            'cep' => 'required',
            'rua' => 'required',
            'num' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required'
        ]);

        if ($id == 0) {
            $profissional = new Cliente;
        } else {
            $profissional = Cliente::where('id', $id);
            if (!$profissional->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $profissional = $profissional->first();
            }
        }

        $profissional->razao_social     = $request->razao_social;
        $profissional->nome_fantasia    = $request->nome_fantasia;
        $profissional->cnpj             = $request->cnpj;
        $profissional->telefone         = $request->telefone;
        $profissional->celular          = $request->celular;
        $profissional->email            = $request->email;
        $profissional->responsavel      = $request->responsavel;
        $profissional->ie               = $request->ie;
        $profissional->cep              = $request->cep;
        $profissional->rua              = $request->rua;
        $profissional->complemento      = $request->complemento;
        $profissional->num              = $request->num;
        $profissional->bairro           = $request->bairro;
        $profissional->cidade           = $request->cidade;
        $profissional->uf               = $request->uf;

        if ($profissional->save()) {
            return \redirect('/clientes')->with([
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
        $profissional = Cliente::where('id', $id);
        if (!$profissional->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $prof = $profissional->first();
            $prof->status = !$prof->status;
            if ($prof->save()) {
                return \redirect('/clientes')->with([
                    'sucesso' => ($prof->status == 0) ? 'Registro inativado com sucesso!' : 'Registro ativado com sucesso!'
                ]);
            } else {
                return \back()->withErrors([
                    'errors' => 'Houve um problema, o registro não foi atualizado.'
                ]);
            }
        }
    }
}
