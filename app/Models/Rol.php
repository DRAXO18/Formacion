<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'nombre',
    ];

    public function accesos()
    {
        return $this->belongsToMany(Acceso::class, 'permiso_acceso', 'id_rol', 'id_acceso');
    }
}
