<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;
    protected $fillable = [
        'correo',
        'nombre1',
        'foto1',
        'categoria',
        'fechaNac1',
        'nombre2',
        'foto2',
        'fechaNac2',
        'club',
        'imagen',
        'controlRCPrimaria',
        'seguidordelineaAmateur',
        'minisumoRcAmateur',
        'minisumoAutonomoAmateur',
        'carreradeInsectosAmateur',
        'peleadeRobotsAmateur',
        'minisumoAutonomoProfesional',
        'minisumoRcProfesional',
        'microsumoProfesional',
        'seguidordelineaProfesional',
        'carreradeInsectosProfesional',
        'creatividadeInnovacionTecnologicaProyectos',
        'guerradeRobotsProfesional1Lb',
        'autoaControlRCBluetooth',
        'robotSoccer',
    ];
}
