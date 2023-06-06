<?php

namespace Database\Seeders;

use App\Models\Fundacao;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FundacaosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fundacoes = [
            ['nome' => 'FUNDEPAG'],
            ['nome' => 'FUNDAG'],
            ['nome' => 'FAPESP']
        ];

        foreach ($fundacoes as $fundacao) {
            Fundacao::create($fundacao);
        }
    }
}
