<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('participantes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre1')->nullable();
            $table->string('foto1')->nullable()->default('user.png');
            $table->date('fechaNac1')->nullable();
            $table->string('nombre2')->nullable();
            $table->string('foto2')->nullable()->default('user.png');
            $table->date('fechaNac2')->nullable();
            $table->string('club')->nullable();
            $table->string('correo')->nullable();
            $table->string('celular')->nullable();
            $table->string('imagen')->nullable();
            $table->string('categoria')->nullable()->default('PARTICIPANTE');
            $table->boolean("controlRCPrimaria")->nullable()->default(false);
            $table->boolean("seguidordelineaAmateur")->nullable()->default(false);
            $table->boolean("minisumoRcAmateur")->nullable()->default(false);
            $table->boolean("minisumoAutonomoAmateur")->nullable()->default(false);
            $table->boolean("carreradeInsectosAmateur")->nullable()->default(false);
            $table->boolean("peleadeRobotsAmateur")->nullable()->default(false);
            $table->boolean("minisumoAutonomoProfesional")->nullable()->default(false);
            $table->boolean("minisumoRcProfesional")->nullable()->default(false);
            $table->boolean("microsumoProfesional")->nullable()->default(false);
            $table->boolean("seguidordelineaProfesional")->nullable()->default(false);
            $table->boolean("carreradeInsectosProfesional")->nullable()->default(false);
            $table->boolean("creatividadeInnovacionTecnologicaProyectos")->nullable()->default(false);
            $table->boolean("guerradeRobotsProfesional1Lb")->nullable()->default(false);
            $table->boolean("autoaControlRCBluetooth")->nullable()->default(false);
            $table->boolean("robotSoccer")->nullable()->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participantes');
    }
};
