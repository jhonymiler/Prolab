<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinhaContaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Account Settings account
    public function index()
    {

        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/minha-conta", 'name' => "Minha Conta"], ['name' => "Dados da Conta"]];
        return view('/minha-conta/conta', [
            'breadcrumbs' => $breadcrumbs,
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = User::where('id', Auth::user()->id);
        UserController::update($request, $user);
        return \back()->with([
            'sucesso' => 'Dados atualizados com sucesso!'
        ]);
    }

    // Account Settings security
    public function senha()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/minha-conta", 'name' => "Minha Conta"], ['name' => "Trocar Senha"]];


        return view('/minha-conta/senha', ['breadcrumbs' => $breadcrumbs]);
    }

    public function troca_senha(Request $request)
    {
        $request->validate([
            'senha-atual' => 'required|current_password:web',
            'senha' => 'required|min:8|confirmed',
        ], [
            'senha-atual.current_password' => 'A senha atual está incorreta.'
        ]);

        $user = User::findOrFail(Auth::user()->id);
        $user->password = Hash::make($request->senha);
        if ($user->save()) {
            return \back()->with([
                'sucesso' => 'Sua senha foi atualizada com sucesso!'
            ]);
        }

        return \back()->with([
            'error' => 'A senha não pode ser atualizada!'
        ]);
    }
}
