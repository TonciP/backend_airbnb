<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use App\Models\Lugar;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LugarController extends Controller
{

    function getByIdLugar(string $lugarId)
    {
        $reserva = Lugar::with('arrendatario')->with('fotos')->with('reservas')->where('id', $lugarId)->first();
        if ($reserva === null) {
            return response()->json(['message' => 'Reserva no encontrada'], 404);
        }
        return response()->json($reserva);
    }
    function getLugarById(string $id)
    {
        $lugar = Lugar::with('arrendatario')->with('fotos')->where('id', $id)->first();
        if ($lugar === null) {
            return response()->json(['message' => 'Lugar no encontrado'], 404);
        }
        return response()->json($lugar);
    }

    function searchLugar(Request $request)
    {
        /*$validation = Validator::make($request->all(), [
            'search' => 'required|string'
        ]);*/

        /*if($validation->fails())
            return response()->json($validation->errors(),404);*/

        $lugar = Lugar::where('ciudad', 'like', '%' . $request->search . '%')->with('arrendatario')->with('fotos')->get();
        return response()->json($lugar);
    }

    function searchLugarAvance(Request $request)
    {
        //$validation = $request->validate([
         //   'search' => 'required|string'
        //]);

       $validation = Validator::make($request->all(), [
            'ciudad' => 'required|string'
        ]);

        if($validation->fails())
            return response()->json($validation->errors(),404);

        $lugar = Lugar::where('nombre', 'like', '%' . $request->nombre . '%')
        ->orWhere('descripcion', 'like', '%' . $request->descripcion . '%')
        ->orWhere('cantPersonas', 'like', '%' . $request->cantPersonas . '%')
        ->orWhere('cantCamas', 'like', '%' . $request->cantCamas . '%')
        ->orWhere('cantBanios', 'like', '%' . $request->cantBanios . '%')
        ->orWhere('cantHabitaciones', 'like', '%' . $request->cantHabitaciones . '%')
        ->orWhere('tieneWifi', 'like', '%' . $request->tieneWifi . '%')
        ->orWhere('cantVehiculosParqueo', 'like', '%' . $request->cantVehiculosParqueo . '%')
        ->orWhere('precioNoche', 'like', '%' . $request->precioNoche . '%')
        ->orWhere('ciudad', 'like', '%' . $request->ciudad . '%')
        ->with('arrendatario')
        ->with('fotos')
        ->get();

        return response()->json($lugar);
    }

    function searchLugarAvance2(Request $request)
    {
        //$validation = $request->validate([
        //   'search' => 'required|string'
        //]);

        $validation = Validator::make($request->all(), [
            'ciudad' => 'required|string'
        ]);

        if($validation->fails())
            return response()->json($validation->errors(),404);


        $lugar = Lugar::query()->where('nombre', 'like', '%' . $request->nombre . '%')
            ->where('descripcion', 'like', '%' . $request->descripcion . '%')
            ->where('cantPersonas', 'like', '%' . $request->cantPersonas . '%')
            ->where('cantCamas', 'like', '%' . $request->cantCamas . '%')
            ->where('cantBanios', 'like', '%' . $request->cantBanios . '%')
            ->where('cantHabitaciones', 'like', '%' . $request->cantHabitaciones . '%')
            ->where('tieneWifi', 'like', '%' . $request->tieneWifi . '%')
            ->where('cantVehiculosParqueo', 'like', '%' . $request->cantVehiculosParqueo . '%')
            ->where('precioNoche', 'like', '%' . $request->precioNoche . '%')
            ->where('ciudad', 'like', '%' . $request->ciudad . '%')
            ->with('arrendatario')
            ->with('fotos')
            ->get();

        return response()->json($lugar);
    }

    function guardarLugar(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'cantPersonas' => 'required|integer',
            'cantCamas' => 'required|integer',
            'cantBanios' => 'required|integer',
            'cantHabitaciones' => 'required|integer',
            'tieneWifi' => 'required|integer',
            'cantVehiculosParqueo' => 'required|integer',
            'precioNoche' => 'required|numeric',
            'costoLimpieza' => 'required|numeric',
            'ciudad' => 'required|string',
            'latitud' => 'required|string',
            'longitud' => 'required|string',
            'arrendatario_id' => 'required|integer',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $lugar = new Lugar();
        $lugar->nombre = $request->nombre;
        $lugar->descripcion = $request->descripcion;
        $lugar->cantPersonas = $request->cantPersonas;
        $lugar->cantCamas = $request->cantCamas;
        $lugar->cantBanios = $request->cantBanios;
        $lugar->cantHabitaciones = $request->cantHabitaciones;
        $lugar->tieneWifi = $request->tieneWifi;
        $lugar->cantVehiculosParqueo = $request->cantVehiculosParqueo;
        $lugar->precioNoche = $request->precioNoche;
        $lugar->costoLimpieza = $request->costoLimpieza;
        $lugar->ciudad = $request->ciudad;
        $lugar->latitud = $request->latitud;
        $lugar->longitud = $request->longitud;
        $lugar->arrendatario_id = $request->arrendatario_id;
        $lugar->save();

        return response()->json($lugar);
    }

    function editarLugar(string $id, Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'cantPersonas' => 'required|integer',
            'cantCamas' => 'required|integer',
            'cantBanios' => 'required|integer',
            'cantHabitaciones' => 'required|integer',
            'tieneWifi' => 'required|integer',
            'cantVehiculosParqueo' => 'required|integer',
            'precioNoche' => 'required|numeric',
            'costoLimpieza' => 'required|numeric',
            'ciudad' => 'required|string',
            'latitud' => 'required|string',
            'longitud' => 'required|string',
            'arrendatario_id' => 'required|integer',
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $lugar = Lugar::all()->where('id', $id)->first();

        $lugar->nombre = $request->nombre;
        $lugar->descripcion = $request->descripcion;
        $lugar->cantPersonas = $request->cantPersonas;
        $lugar->cantCamas = $request->cantCamas;
        $lugar->cantBanios = $request->cantBanios;
        $lugar->cantHabitaciones = $request->cantHabitaciones;
        $lugar->tieneWifi = $request->tieneWifi;
        $lugar->cantVehiculosParqueo = $request->cantVehiculosParqueo;
        $lugar->precioNoche = $request->precioNoche;
        $lugar->costoLimpieza = $request->costoLimpieza;
        $lugar->ciudad = $request->ciudad;
        $lugar->latitud = $request->latitud;
        $lugar->longitud = $request->longitud;
        $lugar->arrendatario_id = $request->arrendatario_id;
        $lugar->save();

        return response()->json($lugar);
    }

    function guardarFotoById(Request $request,string $id)
    {

        $validation = Validator::make($request->all(), [
            'foto' => 'required|image'
        ]);

        if($validation->fails())
            return response()->json($validation->errors(), 404);

        $lugar = Lugar::with('fotos')->where('id', $id)->first();
        if ($lugar === null) {
            return response()->json(['message' => 'Lugar no encontrado'], 404);
        }

        $foto = $request->file('foto');
        $nombre = $foto->getClientOriginalName();
        $foto->move(public_path('fotos'), $nombre);

        //$url = env('APP_URL') . ':8000/fotos/' . $nombre;
        $url = env('APP_URL') . '/fotos/' . $nombre;
        /*$domain = 'http://localhost:8000';
        $url = '/fotos/image.jpg';*/

        //if (!file_exists(public_path('fotos/' . $nombre))) {
        if (file_exists(public_path('fotos/' . $nombre))) {
            $fotos = new Foto();
            $fotos->url = $url;
            $fotos->lugar_id = $id;

            $fotos->save();
        }


        //$lugar->fotos = $nombre;
        //$lugar->save();

        return response()->json(Lugar::with('fotos')->where('id', $id)->first());
    }

    function lugarArrendatarioById(string $id)
    {
        $lugar = Lugar::with('fotos')->where('arrendatario_id', $id)->get();
        if ($lugar === null) {
            return response()->json(['message' => 'Lugar no encontrado'], 404);
        }
        return response()->json($lugar);
    }
}
