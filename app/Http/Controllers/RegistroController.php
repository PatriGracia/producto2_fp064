<?php 
 
namespace App\Http\Controllers;
 
use Illuminate\View\View;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;
 
 class RegistroController extends Controller {
//     /**
//      * Show the profile for a given user.
//      */
    public function index(){
        return view('auth/registro');
    }


//     public function registerProcess(){
//         //Funcion que introducira los datos del formulario de registro a la base de datos
//         $username = $request->input('Username');
//         $idTipoUsuario = 2;
//         $nombre = $request->input('name');
//         $apellido1 = $request->input('apellido1');
//         $apellido2 = $request->input('apellido2');
//         $password = request->input('password');
//         $passwordConfirm = request->input('password_confirm');

//         $hashed_password = password_hash($password, PASSWORD_DEFAULT);

//         //DB::insert('INSERT INTO Personas (Nombre, Apellido1, Apellido2) VALUES (?,?,?)', [$nombre, $apellido1, $apellido2]);
//         DB::table('Personas')->insert(
//             ['Nombre' => $nombre, 'Apellido1' => $apellido1, 'Apellido2' => $apellido2];
//         );

//         $idPersona = DB::select('select Id_persona from Persona where Nombre = ? AND Apellido1 = ? AND Apellido2 = ?', [$nombre,$apellido1,$apellido2]);; 

//         //DB::insert('INSERT INTO Usuarios (Username, Password, Id_persona, Id_tipo_persona ) values (?, ?,?,?)', [$username, $hashed_password, ***idpersona***, 2]);
//         DB::table('Usuarios')->insert(
//             ['Username' => $username, 'Password' => $hashed_password, 'Id_persona' => $idPersona, 'Id_tipo_usuario' => 2];
//         );

//     }
}

?>