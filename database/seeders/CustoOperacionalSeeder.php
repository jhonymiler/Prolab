<?php

namespace Database\Seeders;

use App\Models\CustoOperacional;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustoOperacionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $custoOperacional = CustoOperacional::truncate();
        $custoOperacional = [

            ['descricao' => "Serviços Analises Terc. Labor. (Glicose)", 'medida_id' => 19, 'valor' => "7"],
            ['descricao' => "Serviços Analises Terc. Labor. (Lactato)", 'medida_id' => 19, 'valor' => "14"],
            ['descricao' => "Serviços Analises Terc. Labor. (Ureia)", 'medida_id' => 19, 'valor' => "7"],
            ['descricao' => "Serviços Analises Terc. Labor. (Haptoglobulina)", 'medida_id' => 19, 'valor' => "100"],
            ['descricao' => "Serviços Analises Terc. Labor. (Cerulo Plasmina)", 'medida_id' => 19, 'valor' => "100"],
            ['descricao' => "Serviços Analises Terc. Labor. (Amido)", 'medida_id' => 19, 'valor' => "90"],
            ['descricao' => "Serviços Analises Terc. Labor. EMBRAPA JAGUARIUNA", 'medida_id' => 19, 'valor' => "50"],
            ['descricao' => "Serviços Analises Terc. Labor. (microbiota)", 'medida_id' => 19, 'valor' => "400"],
            ['descricao' => "Serviços Analises Terc. Labor. (ALANTOINA)", 'medida_id' => 19, 'valor' => "21"],
            ['descricao' => "Serviços Analises Terc. Labor. (CREATINA)", 'medida_id' => 19, 'valor' => "6"],
            ['descricao' => "Serviços Analises Terc. Labor. (ACIDO URICO)", 'medida_id' => 19, 'valor' => "5"],
            ['descricao' => "Serviços Analises Terc. Labor. (NITROGENIO TOTAL)", 'medida_id' => 19, 'valor' => "6"]
        ];

        foreach ($custoOperacional as $operacional) {
            CustoOperacional::create($operacional);
        }
    }
}
