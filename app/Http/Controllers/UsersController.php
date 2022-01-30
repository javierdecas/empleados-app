<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function crearUsuario(Request $req)
    {
        $validator = Validator::make(json_decode($req->getContent(), true), [
            // 'title' => 'required|unique:posts|max:255',
            // 'body' => 'required',
            'nombre' => 'required',
            'email' => 'required|unique:App\Models\User,email|email:rfc,dns',
            'password' => 'required|regex:/(?=.*[A-Z])(?=.*[0-9]).{6,}/',
            'tipo_empleado' => 'required',
            'salario' => 'required',
            'biografia' => 'required',
        ]);

        if ($validator->fails())
        {
            return response()->json(['errors'=>$validator->errors()]);
            //return response('Formato no válido');
        }
        else
        {
            //Generar usuario
            $usuario = new User();

            $usuario->nombre = $req->nombre;
            $usuario->email = $req->email;
            $usuario->tipo_empleado = $req->tipo_empleado;
            $usuario->salario = $req->salario;
            $usuario->biografia = $req->biografia;

            $usuario->password = Hash::make($req->password);
            $usuario->save();
        }
    }
    public function login(Request $req)
    {
        //Validar datos

        //Buscar al usuario por su email

        $usuario = User::where('email', $req->email)->first();

        if ($usuario)
        {
            //$contrasenaHash = Hash::make('');
            //Comprobar contraseña
            if (Hash::check($req->password, $usuario->password))
            {
                $token = Hash::make(now().$usuario->id);

                $usuario->api_token = $token;
                $usuario->save();

                return response($token);
            }
            else
            {
                return response('Contraseña incorrecta', 401);
                //return response($contrasenaHash);
            }
        }
    }
    public function recoverPass(Request $req)
    {
        //Validar datos

        //Buscar al usuario por su email

        $usuario = User::where('email', $req->email)->first();

        if ($usuario)
        {
            //Comprobar contraseña

            //Generar contraseña nueva
            // $password = generarStrRand(8);

            // $usuario->password = Hash::make($password);

            // $usuario->save();  
            // //Enviar por email el password sin cifrar

            // return response($password);
        }
    }
}
