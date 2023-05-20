<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'Usuarios';
    protected $primaryKey = 'Id_usuario';

    public $timestamps = false;
    //si solo es de consulta no hace falta especificar llave primaria
    //protected $primaryKey = 'Id_usuario';
}

