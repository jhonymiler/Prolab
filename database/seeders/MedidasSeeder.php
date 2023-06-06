<?php

namespace Database\Seeders;

use App\Models\Medidas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedidasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medidas = [
            ['sigla' => 'Un', 'nome' => 'Unidade', 'tipo' => 1],
            ['sigla' => 'pç', 'nome' => 'Peça', 'tipo' => 1],
            ['sigla' => 'Kit', 'nome' => 'Kit', 'tipo' => 1],
            //Volume
            ['sigla' => 'ml', 'nome' => 'Mililitro', 'tipo' => 2],
            ['sigla' => 'L', 'nome' => 'Litro', 'tipo' => 2],
            ['sigla' => 'Gl', 'nome' => 'Galão', 'tipo' => 2],
            ['sigla' => 'Ds', 'nome' => 'Dose', 'tipo' => 2],
            ['sigla' =>  'm³', 'nome' => 'Metro Cúbico', 'tipo' => 2],
            // Peso
            ['sigla' => 'g', 'nome' => 'Grama', 'tipo' => 3],
            ['sigla' => 'Kg', 'nome' => 'Quilo', 'tipo' => 3],
            ['sigla' => 'Ton', 'nome' => 'Tonelada', 'tipo' => 3],
            // Comprimento
            ['sigla' => 'mm', 'nome' => 'Milímetro', 'tipo' => 4],
            ['sigla' => 'cm', 'nome' => 'Centímetro', 'tipo' => 4],
            ['sigla' => 'm', 'nome' => 'Metro', 'tipo' => 4],
            ['sigla' => 'Km', 'nome' => 'Quilômetro', 'tipo' => 4],
            // Energia
            ['sigla' => 'w', 'nome' => 'Watts', 'tipo' => 5],
            ['sigla' => 'Kw', 'nome' => 'Quilowatts', 'tipo' => 5],
            // Tempo
            ['sigla' => 'Hr', 'nome' => 'Hora', 'tipo' => 6],
            //Amostras
            ['sigla' =>  'Am', 'nome' => 'Amostra', 'tipo' => 2]
        ];

        foreach ($medidas as $md) {
            Medidas::create($md);
        }
    }
}
