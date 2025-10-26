<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        //'lugar_id',
        //'cliente_id',
        'fechaInicio',
        'fechaFin',
        'precioTotal',
        'precioLimpieza',
        'precioNoches',
        'precioServicio',
        //'costoLimpieza',
        //'ciudad',
        //'latitud',
        //'longitud',
        // cliente
    ];
    protected $hidden = [
        //'password',
        'costoLimpieza',
        'ciudad',
        'latitud',
        'longitud',
        'lugar_id',
        'cliente_id'

    ];

    function cliente()
    {
        return $this->hasOne(User::class, 'id', 'cliente_id');
    }

    function lugar()
    {
        return $this->hasMany(Lugar::class, 'id', 'lugar_id')->with('arrendatario')->with('fotos');
    }
}
