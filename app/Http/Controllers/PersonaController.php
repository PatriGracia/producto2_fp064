<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function index(){
        $personas = Persona::all(); //no funciona
        //$personas = DB::table('Personas')->get();
        //$personas = Persona::paginate();
        //return $p;
        return view('personas', compact('personas'));
    }

    public function create(){
        return "Página para crear Personas";
    }

    public function show($id){
        /*
        En una vista, se pasaría así la variable:
        //persona es como pondría en el echo en el html
        return view('personas.show', ['persona' => $id]);
        otra forma:
        return view('personas.show', compact('persona'));
        */
        $persona = Persona::find($id);
        //return $persona;
        return "Página para mostrar una Persona con $id";
    }
}
