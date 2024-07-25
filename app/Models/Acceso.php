<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    use HasFactory;

    protected $table = 'accesos';


    protected $fillable = [
        'nombre',
        'controlador',
        'tipo',
    ];

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'permiso_acceso', 'id_acceso', 'id_rol');
    }
}
