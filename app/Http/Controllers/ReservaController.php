<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservaController extends Controller
{
    function getByIdLugar(string $lugarId)
    {
        $reserva = Reserva::with('cliente')->with('lugar')->where('lugar_id', $lugarId)->first();
        if ($reserva === null) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json($reserva);
    }

    function getByIdCliente(string $clienteId)
    {
        $reserva = Reserva::with('cliente')->with('lugar')->where('cliente_id', $clienteId)->get();
        if ($reserva === null) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json($reserva);
    }

    function saveReserva(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'lugar_id' => 'required|numeric',
            'cliente_id' => 'required|numeric',
            'fechaInicio' => 'required|date',
            'fechaFin' => 'required|date',
            'precioTotal' => 'required|numeric',
            'precioNoches' => 'required|numeric',
            'precioServicio' => 'required|numeric',
            'precioLimpieza' => 'required|numeric',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $reserva = new Reserva();
        $reserva->lugar_id = $request->lugar_id;
        $reserva->cliente_id = $request->cliente_id;
        $reserva->fechaInicio = $request->fechaInicio;
        $reserva->fechaFin = $request->fechaFin;
        $reserva->precioTotal = $request->precioTotal;
        $reserva->precioLimpieza = $request->precioLimpieza;
        $reserva->precioNoches = $request->precioNoches;
        $reserva->precioServicio = $request->precioServicio;
        $reserva->costoLimpieza = 0.0;
        $reserva->ciudad = '';
        $reserva->latitud = '';
        $reserva->longitud = '';
        $reserva->save();
        return response()->json($reserva);

    }
}
