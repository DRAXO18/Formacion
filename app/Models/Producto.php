<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'codigo',
        'idMarca',
        'precio',
        'foto',
        'id_responsable',
    ];

    public function marca()
    {
        return $this->belongsTo(Marca::class, 'idMarca', 'id');
    }
}
