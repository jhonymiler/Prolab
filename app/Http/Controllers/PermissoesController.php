<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use stdClass;

class PermissoesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(['permission: criar permissoes|editar permissoes|deletar permissoes|ler permissoes']);
    }
    public function index()
    {

        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/users", 'name' => "Usuários"], ['name' => "Permissões"]
        ];

        return view('controle-acesso/permissoes', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    public function nova(Request $request)
    {
        $request->validate([
            'permissao' => 'required'
        ]);

        $nomePermissao = strtolower($request->permissao);
        if (Permission::where('name', 'like', '%' . $nomePermissao . '%')->doesntExist())
            foreach (['criar', 'editar', 'deletar', 'ler'] as $permissao) {
                $permissoes[] = Permission::create(['name' => "{$permissao} {$nomePermissao}"]);
            }

        if (count($permissoes) == 4) {
            return \redirect('users/permissoes')->with([
                'sucesso' => 'Permissão Cadastrada Com Sucesso'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Os dados não puderam ser salvos!'
            ]);
        }
    }

    public function delete(int $id)
    {
        return Permission::find($id)->delete();
    }


    public function getListPermissoes()
    {
        $permissoes = Permission::with('roles')->get()->toArray();
        $dados = new stdClass();
        $dados->data = $permissoes;
        return response()->json(
            $dados,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
