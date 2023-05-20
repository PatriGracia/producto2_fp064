<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Usuario;
use App\Models\Persona;

 
class LoginController extends Controller {
    
    public function register(Request $request) {
        //Validar los datos
        $usuario = new Usuario();
        $persona = new Persona();  
        $Id_ultima_persona = null;
        $tipo_usuario = 2;
        //name, apellido1, apellido2, username, password  
        $persona->Nombre = $request->name;   
        $persona->Apellido1 = $request->apellido1;
        $persona->Apellido2 = $request->apellido2; 
        //guardar persona
        $persona->save();
        $Id_ultima_persona = Persona::latest('Id_persona')->first()->Id_persona;
        $usuario->Username = $request->username;
        $usuario->Password = Hash::make($request->password);
        $usuario->Id_Persona = $Id_ultima_persona;
        //$persona->Id_persona;
        $usuario->Id_tipo_usuario = $tipo_usuario;
        $usuario->save();

        Auth::login($usuario);

        return redirect(route('privada'));
        //redirigir luego al login
        
    }

    public function login(Request $request) {

        $usuarioLog = Usuario::where('Username','=', $request->username)->first();
        if($usuarioLog->Username == $request->username && Hash::check($request->password, $usuarioLog->Password)){
            
                Auth::login($usuarioLog);

                return redirect(route('privada'));  
            
        }else{
            return redirect(route('login')); 
        }
    }

    public function logout(Request $request) {
        //return view('auth/login');
        Auth::logout();
        //$request->session()->invalidate();
        //$request->session()->regenerateToken();
        return redirect(route('login'));
    }
}
//return view('auth/login');
?>