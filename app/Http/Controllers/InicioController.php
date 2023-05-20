<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    //
    public function __invoke(){
        //usamos __invoke cuando queremos que administre una única ruta
        return view('inicio');
    }
}
