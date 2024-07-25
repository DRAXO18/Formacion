<?php

// app/Models/Venta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'id_tipo_venta',
        'cliente_id',
        'id_usuario', // Nuevo campo
        'fecha_venta',
        'total',
    ];

    public function detallesVentas()
    {
        return $this->hasMany(DetallesVenta::class);
    }

    public function tipoVenta()
    {
        return $this->belongsTo(TipoVenta::class, 'id_tipo_venta');
    }

    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
    
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
