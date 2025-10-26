<?php

namespace App\Http\Controllers;

use App\Models\Arrendatario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ArrendatarioController extends Controller
{
    function login(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $user = Arrendatario::where('email', $request->email)->first();
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

        $arrendatario = new Arrendatario();
        $arrendatario->nombrecompleto = $request->nombrecompleto;
        $arrendatario->email = $request->email;
        $arrendatario->password = Hash::make($request->password);
        $arrendatario->telefono = $request->telefono;
        $arrendatario->save();
        return response()->json($arrendatario);

    }
}
