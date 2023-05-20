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
        Schema::dropIfExists('Usuarios');
        Schema::create('Usuarios', function(Blueprint $table){
            /*
            CREATE TABLE `Usuarios` (
                `Id_usuario` int NOT NULL,
                `Username` varchar(100) NOT NULL,
                `Password` varchar(100) NOT NULL,
                `Id_Persona` int NOT NULL,
                `Id_tipo_usuario` int NOT NULL
            */
            $table->id('Id_usuario');
            $table->string('Username')->unique();
            $table->string('Password');
            $table->unsignedBigInteger('Id_Persona');
            $table->unsignedBigInteger('Id_tipo_usuario');
            $table->foreign('Id_Persona')->references('Id_persona')->on('Personas');
            $table->foreign('Id_tipo_usuario')->references('Id_tipo_usuario')->on('Tipos_usuarios');

        });

        //$credentials = tbl_usuario::select('rol')->orderBy('usu_id', 'desc')->first();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Usuarios');
    }
};

?>