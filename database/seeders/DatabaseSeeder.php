<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Tipos_usuario;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //php artisan migrate:fresh --seed

        $tipo_usuario = new Tipos_usuario;
        $tipo_usuario2 = new Tipos_usuario;
        $tipo_usuario3 = new Tipos_usuario;

        $tipo_usuario->Descripcion = "Admin";
        $tipo_usuario2->Descripcion = "Usuario";
        $tipo_usuario3->Descripcion = "Ponente";

        $tipo_usuario->save();
        $tipo_usuario2->save();
        $tipo_usuario3->save();
    }
}
