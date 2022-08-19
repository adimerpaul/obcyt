<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("categorias")->insert([
            ["nombre"=>"Control RC Primaria"],
            ["nombre"=>"Seguidor de linea Amateur"],
            ["nombre"=>"Minisumo Rc Amateur"],
            ["nombre"=>"Minisumo Autonomo Amateur"],
            ["nombre"=>"Carrera de Insectos Amateur"],
            ["nombre"=>"Pelea de Robots Amateur"],
            ["nombre"=>"Minisumo Autonomo Profesional"],
            ["nombre"=>"Minisumo Rc Profesional"],
            ["nombre"=>"Microsumo Profesional"],
            ["nombre"=>"Seguidor de linea Profesional"],
            ["nombre"=>"Carrera de Insectos Profesional"],
            ["nombre"=>"Creatividad e Innovacion Tecnologica Proyectos"],
            ["nombre"=>"Guerra de Robots Profesional 1Lb"],
            ["nombre"=>"Auto a Control RC Bluetooth"],
            ["nombre"=>"Robot Soccer"],
        ]);
    }
}
