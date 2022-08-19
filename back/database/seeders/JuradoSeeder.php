<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JuradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jurados')->insert([
            [
                'nombre' => 'ING ADIMER PAUL CHAMBI AJATA',
                'cargo' => 'INGENIERO INFORMATICA',
            ],
            [
                'nombre' => 'ING ALEJANDRO LOPEZ GUTIERREZ',
                'cargo' => 'INGENIERO SISTEMAS E INFORMATICA',
            ],

        ]);
    }
}
