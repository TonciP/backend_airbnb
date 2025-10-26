<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    function GetAll()
    {
        return User::all();
    }
    function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'password' => 'required|string',
            'email' => 'required|email',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $user = User::where('email', $request->email)->first();
        if ($user === null) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Contraseña incorrecta'], 401);
        }
        return response()->json($user);

    }

    function save(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombrecompleto' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'telefono' => 'required|string',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $user = new User();
        $user->nombrecompleto = $request->nombrecompleto;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->telefono = $request->telefono;
        $user->save();
        return response()->json($user);

    }
}
