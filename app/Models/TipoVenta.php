<?php

// app/Models/TipoVenta.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoVenta extends Model
{
    use HasFactory;

    protected $table = 'tipo_venta';

    protected $fillable = [
        'nombre',
    ];

    public function ventas()
    {
        return $this->hasMany(Venta::class, 'id_tipo_venta');
    }
}
