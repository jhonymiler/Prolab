<?php

namespace Database\Seeders;

use App\Models\TipoProjeto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoProjeto = [
            ['nome' => 'Confinamento Baia Coletiva'],
            ['nome' => 'Confinamento Baia Individual'],
            ['nome' => 'Confinamento Integrado'],
            ['nome' => 'Dual Flow'],
            ['nome' => 'Dual Flow + Prod. Gas Amkom'],
            ['nome' => 'Experimento In Situ'],
            ['nome' => 'In Vitro Digestibilidade Intestinal'],
            ['nome' => 'Prod de Gás Ankom']
        ];

        foreach ($tipoProjeto as $tipo) {
            TipoProjeto::create($tipo);
        }
    }
}
