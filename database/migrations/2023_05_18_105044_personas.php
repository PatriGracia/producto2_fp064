<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Personas', function(Blueprint $table){
            //`Id_persona`, `Nombre`, `Apellido1`, `Apellido2

            $table->id('Id_persona');
            $table->string('Nombre');
            $table->string('Apellido1');
            $table->string('Apellido2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usuarios');
        Schema::dropIfExists('Personas');
    }
};
