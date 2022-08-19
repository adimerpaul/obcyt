<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParticipanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("participantes")->insert([
            [
                'correo'=>"adimer101@gmail.com",
                'nombre1'=>"ADIMER PAUL CHAMBI AJATA",
                'fechaNac1'=>"2000-01-01",
                'nombre2'=>"ALEJANDRO LOPEZ GUTIERREZ",
                'fechaNac2'=>"2000-01-01",
                'club'=>"ORURO CLUB",
                'controlRCPrimaria'=>true,
                'seguidordelineaAmateur'=>true,
                'minisumoRcAmateur'=>true,
                'minisumoAutonomoAmateur'=>true,
                'carreradeInsectosAmateur'=>true,
                'peleadeRobotsAmateur'=>true,
                'minisumoAutonomoProfesional'=>true,
                'minisumoRcProfesional'=>true,
                'microsumoProfesional'=>true,
                'seguidordelineaProfesional'=>true,
                'carreradeInsectosProfesional'=>true,
                'creatividadeInnovacionTecnologicaProyectos'=>true,
                'guerradeRobotsProfesional1Lb'=>true,
                'autoaControlRCBluetooth'=>true,
                'robotSoccer'=>true,
            ]
        ]);
    }
}
