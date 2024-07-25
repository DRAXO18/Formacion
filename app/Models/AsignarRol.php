<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignarRol extends Model
{
    use HasFactory;

    protected $table = 'asignar_rol';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'correo',
        'id_rol',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
