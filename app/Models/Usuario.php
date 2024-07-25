<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identificacion',
        'idtipo_usuario',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'idtipo_usuario');
    }
}
