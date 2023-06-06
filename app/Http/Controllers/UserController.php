<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use stdClass;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['permission:ler usuarios|criar usuarios|editar usuarios|deletar usuarios|ler permissoes|editar permissoes']);
    // }
    // Account Settings account
    public function index()
    {
        $users = User::all();
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['name' => "Usuários"]];
        $totalUsers = $users->count();
        $usersInativos = $users->where('status', 0)->count();
        $usersPendentes = $users->where('status', null)->count();
        $usersAtivos = $users->where('status', 1)->count();

        return view('/user/usuarios', [
            'breadcrumbs' => $breadcrumbs,
            'totalUsers' => $totalUsers,
            'usersAtivos' => $usersAtivos,
            'usersInativos' => $usersInativos,
            'usersPendentes' => $usersPendentes,
            'niveis' => Role::all()
        ]);
    }

    public function novo()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/users/novo", 'name' => "Novo Usuário"], ['name' => "Dados da Conta"]];

        $user = new stdClass();
        $user->avatar = 'avatar.jpg';
        $user->name = '';
        $user->celular = '';
        $user->email = '';
        $user->status = 0;

        return view('/user/conta', [
            'breadcrumbs' => $breadcrumbs,
            'user' => $user,
            'niveis' => Role::all()
        ]);
    }

    public function create(Request $request)
    {
        $validos = $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'celular' => 'required',
            'nivel' => 'required'
        ]);

        $usuario = $request->except(['_token', 'nivel']);

        $usuario['password'] = Hash::make('senha');
        if ($user = User::create($usuario)) {

            $user->assignRole($request->nivel);
            if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {

                $usuario['avatar'] = trim(Str::slug($usuario['name'])) . '.' . $request->avatar->extension();
                // Faz o upload:
                $upload = $request->avatar->storeAs('public/avatar', $usuario['avatar']);
                // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

                // Verifica se NÃO deu certo o upload (Redireciona de volta)
                if (!$upload)
                    return redirect()
                        ->back()
                        ->with('error', 'Falha ao fazer upload')
                        ->withInput();
            }
            return \redirect('/users')->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Os dados não puderam ser salvos!'
            ]);
        }
    }

    public function show(int $id)
    {

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/users/show/{$id}", 'name' => "Conta do Usuário"], ['name' => "Dados da Conta"]];
        return view('/user/conta', [
            'breadcrumbs' => $breadcrumbs,
            'user' => User::find($id),
            'niveis' => Role::all()
        ]);
    }

    public function show_permissoes(int $id)
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/users/show/{$id}", 'name' => "Conta do Usuário"], ['name' => "Permissões da Conta"]];


        $user = User::whereId($id);

        if ($user->exists()) {

            $user = $user->first();
            $nivel = Role::whereId($user->nivel->id);
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

            $permViaNivel = $user->getPermissionsViaRoles()->pluck('id')->toArray();
            $permDireta = $user->getDirectPermissions()->pluck('id')->toArray();


            //dd($arrPermissoes);
            return view('/user/conta-permissoes', [
                'breadcrumbs' => $breadcrumbs,
                'permissoes' => $arrPermissoes,
                'form' => true,
                'action' => '/users/edit/permissoes/' . $id,
                'dadosNivel' => $nivel->first(),
                'permViaNivel' => $permViaNivel,
                'permDireta' => $permDireta,
                'user' => $user

            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Este Registro Não Existe!'
            ]);
        }
    }

    public function update_permissao(Request $request, int $id)
    {

        $user = User::whereId($id);

        if ($user->exists()) {

            $user = $user->first();
            $nivel = Role::whereId($user->nivel->id);
            $nivel = $nivel->first();


            if ($request->permissoes) {
                foreach ($request->permissoes as $permissao) {
                    $permissoes[] = strtolower($permissao);
                }
            } else {
                $permissoes = [];
            }

            $user->syncPermissions($permissoes);

            return \redirect('/users/show/permissoes/' . $id)->with([
                'sucesso' => 'Dados atualizados com sucesso!'
            ]);
        } else {
            return \back()->withErrors([
                'errors' => 'Este Registro Não Existe!'
            ]);
        }
    }


    public function getUsers()
    {
        $dados = new \stdClass();
        $dados->data = User::all();
        return response()->json(
            $dados,
            200,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    public function edit(Request $request, int $id)
    {
        $user = User::where('id', $id);
        self::update($request, $user);
        return \back()->with([
            'sucesso' => 'Dados atualizados com sucesso!'
        ]);
    }

    public static function update($request, $user)
    {
        $validos = $request->validate([
            'avatar' => 'image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required',
            'email' => 'required',
            'celular' => 'required'
        ]);
        $usuario = $request->except(['_token', 'nivel']);
        $dadosUser = $user->first();

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            //deleta avatar antigo
            if (File::exists(public_path('public/' . $dadosUser->avatar)) && $dadosUser->avatar != 'avatar.jpg') {
                File::delete(public_path('public/' . $dadosUser->avatar));
            }

            $usuario['avatar'] = trim(Str::slug($usuario['name'])) . '.' . $request->avatar->extension();
            // Faz o upload:
            $upload = $request->avatar->storeAs('public/avatar', $usuario['avatar']);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if (!$upload)
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
        }

        if (isset($request->nivel) && $request->nivel != $dadosUser->nivel->id) {
            $dadosUser->removeRole($dadosUser->nivel->name);
            $dadosUser->assignRole($request->nivel);
        }
        return $user->update($usuario);
    }


    public function tootle_status(Request $request, int $id)
    {
        $user = User::findOrFail($id);
        $user->status = $request->status;
        return $user->save();
    }
}
