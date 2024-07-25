<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock_productos';

    protected $fillable = [
        'idProducto',
        'tipo_movimiento',
        'cantidad'
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'idProducto');
    }
}

