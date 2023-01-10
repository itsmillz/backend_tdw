<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(UserRequest $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        //Encripta la contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "status"=>1,
            "Mensaje"=> $request->all()
        ],Response::HTTP_OK);

    }
    public function login(LoginRequest $request){

        $user = User::where("email","=",$request->email)->first();//Verifica si existe un registro con ese correo
        if(isset($user->id)){
            if(Hash::check($request->password,$user->password)){
                //Creamos el token
                $token = $user->createToken("auth_token")-> plainTextToken;
                return response()->json([
                    "status"=> 1,
                    "mensaje"=> "Usuario logueado exitosamente",
                    "token" => $token
                ],200);
            }else{
                return response()->json([
                    "status"=>0,
                    "mensaje" => "La contraseña es incorrecta"
                ],200);
            }
        }else{
            return response()->json([
                "status"=>0,
                "mensaje" => "Usurio no registrado"
            ],404);
        }
    }
    public function userProfile(){
        return response()->json([
            "status"=>0,
            "mensaje" => "Acerca del perfil",
            "data" => auth()->user()
        ],404);
    }
    public function logout(){
        auth()->user() -> tokens()->delete();
        return response()->json([
            "status"=>1,
            "mensaje"=>"Cierre de sesión"
        ]);
    }
}
