<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsSeeder::class,
            UserSeeder::class,
            ProfissionaisSeeder::class,
            CentroCustoSeeder::class,
            FundacaosSeeder::class,
            TipoProjetoSeeder::class,
            EnergiaSeeder::class,
            MedidasSeeder::class,
            CustoOperacionalSeeder::class
        ]);
    }
}
