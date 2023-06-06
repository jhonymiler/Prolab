<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class NiveisController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission: criar niveis|editar niveis|deletar niveis|ler niveis']);
    }
    public function niveis()
    {
        $niveis = Role::with('users')->where('name', '!=', 'Super-Admin')->get();
        $permissoes = Permission::all();

        foreach ($permissoes as $k => $permissao) {
            $modulo_permissao = explode(' ', $permissao->name);
            $mod_name = array_shift($modulo_permissao);

            $modulo = '';
            foreach ($modulo_permissao as $mp) {
                $modulo .= ucfirst($mp) . ' ';
            }

            $arrPermissoes[$modulo][$k]['id'] = $permissao->id;
            $arrPermissoes[$modulo][$k]['name'] = ucfirst($mod_name);
        }
        return [
            'niveis' => $niveis,
            'permissoes' => $arrPermissoes
        ];
    }
    public function index(Request $request)
    {

        $dados = $this->niveis();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/users", 'name' => "Usuários"], ['name' => "Níveis"]
        ];

        //dd($arrPermissoes);
        return view('controle-acesso/niveis', [
            'breadcrumbs' => $breadcrumbs,
            'niveis' => $dados['niveis'],
            'permissoes' => $dados['permissoes'],
            'form' => false
        ]);
    }
    public function novo()
    {
        $dados = $this->niveis();
        $breadcrumbs = [
            ['link' => "/", 'name' => "Home"], ['link' => "/users", 'name' => "Usuários"], ['link' => "/users/niveis", 'name' => "Níveis"], ['name' => 'Novo']
        ];

        //dd($arrPermissoes);
        return view('controle-acesso/niveis', [
            'breadcrumbs' => $breadcrumbs,
            'niveis' => $dados['niveis'],
            'permissoes' => $dados['permissoes'],
            'form' => true,
            'action' => '/users/niveis/novo'
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'nivel' => 'required',
        ]);

        if (isset($request->permissoes)) {
            foreach ($request->permissoes as $permissao) {
                $permissoes[] = strtolower($permissao);
            }
        }


        $nomeNivel = ucfirst(strtolower($request->nivel));
        if (!Role::whereName($request->nivel)->exists()) {
            $nivel  = Role::create([
                'name' => $nomeNivel
            ]);

            if (isset($request->permissoes)) {
                $nivel->syncPermissions($permissoes);
            }
            //dd($nivel->permissions->pluck('name')->toArray());
            return \redirect('/users/niveis')->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Este nível já existe, por favor escolha outro nome.!'
            ]);
        }
    }

    public function editar(int $id)
    {
        $dados = $this->niveis();
        $nivel = Role::whereId($id);
        if ($nivel->exists()) {
            $breadcrumbs = [
                ['link' => "/", 'name' => "Home"], ['link' => "/users", 'name' => "Usuários"], ['link' => "/users/niveis", 'name' => "Níveis"], ['name' => 'Novo']
            ];

            //dd($arrPermissoes);
            return view('controle-acesso/niveis', [
                'breadcrumbs' => $breadcrumbs,
                'niveis' => $dados['niveis'],
                'permissoes' => $dados['permissoes'],
                'form' => true,
                'action' => '/users/niveis/editar/' . $id,
                'dadosNivel' => $nivel->first()
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Este Registro Não Existe!'
            ]);
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nivel' => 'required',
        ]);
        $nivel = Role::whereId($id);
        if ($nivel->exists()) {
            $nivel = $nivel->first();
            $nomeNivel = ucfirst(strtolower($request->nivel));
            $nivel->name =  $nomeNivel;
            $nivel->save();

            if ($request->permissoes) {
                foreach ($request->permissoes as $permissao) {
                    $permissoes[] = strtolower($permissao);
                }
            } else {
                $permissoes = [];
            }
            $nivel->syncPermissions($permissoes);

            return \redirect('/users/niveis/editar/' . $nivel->id)->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Este Registro Não Existe!'
            ]);
        }
    }
}
