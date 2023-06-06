<?php

namespace Database\Seeders;

use App\Models\Profissional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfissionaisSeeder extends Seeder
{
    /**
     * Run the database seeds
     *
     * @return void
     */
    public function run()
    {
        $profissionais = [
            ['cargo' => 'Diretora',                   'valor_mercado' => 25000.00],
            ['cargo' => 'Pesquisador Chefe',          'valor_mercado' => 16000.00],
            ['cargo' => 'Coordenador',                'valor_mercado' => 8000.00],
            ['cargo' => 'Assistente de Laboratorio',  'valor_mercado' => 4000.00],
            ['cargo' => 'Faxineira',                  'valor_mercado' => 1500.00],
            ['cargo' => 'Estagiário',                 'valor_mercado' => 2000.00],
            ['cargo' => 'Tratorista',                 'valor_mercado' => 2000.00],
            ['cargo' => 'Tratador',                   'valor_mercado' => 2000.00]

        ];

        foreach ($profissionais as $prof) {
            Profissional::create($prof);
        }
    }
}
