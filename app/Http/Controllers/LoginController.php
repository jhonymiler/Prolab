<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Página inicial do login
     */
    public function index()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/login/index', ['pageConfigs' => $pageConfigs]);
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($user = User::where('email', $request->email)->first()) {
            if ($user->status === null) {
                Session::put('user-senha', $user);
                return redirect('/login/reset-senha');
            } else {
                if (Auth::attempt($credentials, $request->remember)) {
                    // Authentication passed...
                    return redirect('/');
                }
            }
        }

        return \back()->withErrors([
            'email' => 'Email ou senha incorretos!'
        ]);
    }

    /**
     * Página para digitar uma nova senha
     */
    public function reset_senha()
    {
        $pageConfigs = ['blankPage' => true];

        if (Session::has('user-senha')) {
            return view('login/reset-senha', [
                'pageConfigs' => $pageConfigs,
                'user' => Session::get('user-senha')
            ]);
        }
        return \back()->withErrors([
            'errors' => 'Você não pode acessar está página antes de ser registrado!'
        ]);
    }

    public function update_senha(Request $request)
    {
        $request->validate([
            'senha' => 'required|min:8|confirmed',
        ]);

        $user = User::findOrFail(Session::get('user-senha')->id);
        $user->password = Hash::make($request->senha);
        $user->status = 1;
        if ($user->save()) {
            // Authentication passed...
            return \redirect('/login')->with([
                'sucesso' => 'Sua senha foi atualizada com sucesso, por favor realize novamente o login!'
            ]);
        }

        return \back()->with([
            'error' => 'A senha não pode ser atualizada!'
        ]);
    }

    /**
     * Página esqueci a senha
     */
    public function esqueceu_senha()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/login/esqueceu-senha', ['pageConfigs' => $pageConfigs]);
    }


    /**
     * Página para confirmação de email
     */
    public function confirma_email()
    {
        $pageConfigs = ['blankPage' => true];
        return view('/login/confirma-email', ['pageConfigs' => $pageConfigs]);
    }

    public function nova_senha()
    {
        // code...
    }

    public function sair()
    {
        Auth::logout();
        return redirect('login');
    }
}
