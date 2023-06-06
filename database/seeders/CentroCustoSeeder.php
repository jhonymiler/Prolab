<?php

namespace Database\Seeders;

use App\Models\CentroCusto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CentroCustoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $centroCusto = [
            ['nome' => 'Laboratório']
        ];

        foreach ($centroCusto as $cc) {
            CentroCusto::create($cc);
        }
    }
}
