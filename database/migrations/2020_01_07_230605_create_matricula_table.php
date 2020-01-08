<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            
            $table->unsignedBigInteger('periodo_id')->nullable();
            $table->foreign('periodo_id')
                ->references('id')->on('periodos')
                ->onDelete('set null');

            $table->unsignedBigInteger('alumno_id')->nullable();
            $table->foreign('alumno_id')
                    ->references('id')->on('alumnos')
                    ->onDelete('cascade');

            
            $table->unsignedBigInteger('curso_id')->nullable();
            $table->foreign('curso_id')
                        ->references('id')->on('cursos')
                        ->onDelete('cascade');

            $table->unsignedBigInteger('laboratorio_id')->nullable();
            $table->foreign('laboratorio_id')
                        ->references('id')->on('laboratorios')
                        ->onDelete('set null');
        
            $table->unique(['alumno_id', 'curso_id','periodo_id']);
                    
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}
