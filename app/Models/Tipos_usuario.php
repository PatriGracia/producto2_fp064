<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipos_usuario extends Model
{
    use HasFactory;

    protected $table = "Tipos_usuarios";
    protected $primaryKey = 'Id_tipo_usuario';
    public $timestamps = false;
}
