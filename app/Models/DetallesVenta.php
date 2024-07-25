<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Producto as Product;

class DetallesVenta extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'id','id_venta', 'id_producto', 'cantidad', 'subtotal'
    ];

    // Relaciones Eloquent si las tienes definidas
    public function venta()
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
}
