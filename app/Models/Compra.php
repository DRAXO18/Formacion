<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_tipo_compra',
        'proveedor_id',
        'id_usuario',
        'fecha_compra',
        'total',
    ];

    public function proveedor()
    {
        return $this->belongsTo(User::class, 'proveedor_id')->where('idtipo_usuario', 2);
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function tipoCompra()
    {
        return $this->belongsTo(TipoVenta::class, 'id_tipo_compra');
    }

    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class);
    }
}
