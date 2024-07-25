<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tienda extends Model
{
    use HasFactory;

    protected $table = 'tienda';

    protected $fillable = [
        'nombre_tienda',
        'direccion',
        'id_ubigeo',
        'foto'
    ];

    public function ubigeo()
    {
        return $this->belongsTo(Ubigeo::class, 'id_ubigeo');
    }
}
