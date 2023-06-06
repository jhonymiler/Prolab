<?php

namespace Database\Seeders;

use App\Models\Energia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnergiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $energia = [

            ['data' => "2022-01-01", 'consumo' => 3692.00, 'valor' => "2364,16"],
            ['data' => "2022-02-01", 'consumo' => 1548.00, 'valor' => "951,41"],
            ['data' => "2022-03-01", 'consumo' => 6140.00, 'valor' => "3703,00"],
            ['data' => "2022-04-01", 'consumo' => 2087.00, 'valor' => "1273,14"],
            ['data' => "2022-05-01", 'consumo' => 5399.00, 'valor' => "3414,00"],
            ['data' => "2022-06-01", 'consumo' => 2611.00, 'valor' => "1835,00"],
            ['data' => "2022-07-01", 'consumo' => 2867.00, 'valor' => "2047,09"],
            ['data' => "2022-08-01", 'consumo' => 2990.00, 'valor' => "2204,46"],
            ['data' => "2022-09-01", 'consumo' => 1783.00, 'valor' => "1783,00"],
            ['data' => "2022-10-01", 'consumo' => 3190.00, 'valor' => "3190,00"],
            ['data' => "2022-11-01", 'consumo' => 2584.00, 'valor' => "1693,67"]
        ];

        foreach ($energia as $ener) {
            Energia::create($ener);
        }
    }
}
