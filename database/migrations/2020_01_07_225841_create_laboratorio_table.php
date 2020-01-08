<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratorioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('cupos')->default(20);
            $table->string('grupo',1);
            $table->timestamps();

            $table->unsignedBigInteger('curso_id');
            $table->foreign('curso_id')
                ->references('id')->on('cursos')
                ->onDelealumnote('cascade');

            $table->unsignedBigInteger('profesor_id')->nullable();
            $table->foreign('profesor_id')
                    ->references('id')->on('profesores')
                    ->onDelete('set null');
            
            $table->unique(['grupo', 'curso_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('labolatorios');
    }
}
