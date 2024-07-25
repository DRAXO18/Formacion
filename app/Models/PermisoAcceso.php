<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoAcceso extends Model
{
    use HasFactory;

    protected $table = 'permiso_acceso';

    protected $fillable = ['id_rol', 'id_acceso'];
}
