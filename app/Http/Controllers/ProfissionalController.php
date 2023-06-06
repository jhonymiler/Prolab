<?php

namespace App\Http\Controllers;

use App\Models\Profissional;
use Illuminate\Http\Request;
use stdClass;

class ProfissionalController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $breadcrumbs = [['link' => "/", 'name' => "Home"], ['link' => "/profissionais", 'name' => "Cadastro de Profissionais"], ['name' => "Lista"]];

        $profs = Profissional::all();

        return view('cadastros/profissionais', [
            'breadcrumbs' => $breadcrumbs,
            'profs' => $profs
        ]);
    }

    public function save(Request $request, int $id = 0)
    {
        $request->validate([
            'cargo' => 'required',
            'valor_mercado' => 'required'
        ]);

        if ($id == 0) {
            $profissional = new Profissional;
        } else {
            $profissional = Profissional::where('id', $id);
            if (!$profissional->exists()) {
                return \back()->withErrors([
                    'errors' => 'Este registro não existe!'
                ]);
            } else {
                $profissional = $profissional->first();
            }
        }

        $profissional->cargo = $request->cargo;
        $profissional->valor_mercado = $request->valor_mercado;

        if ($profissional->save()) {
            return \redirect('/profissionais')->with([
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
        $profissional = Profissional::where('id', $id);
        if (!$profissional->exists()) {
            return \back()->withErrors([
                'errors' => 'Este registro não existe!'
            ]);
        } else {
            $prof = $profissional->first();
            $prof->status = !$prof->status;
            if ($prof->save()) {
                return \redirect('/profissionais')->with([
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
