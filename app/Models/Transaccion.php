<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    use HasFactory;

    protected $table = 'transacciones';

    protected $fillable = ['billetera_id', 'tipo', 'monto', 'descripcion', 'fecha'];

    public function billetera()
    {
        return $this->belongsTo(Billetera::class);
    }
}
