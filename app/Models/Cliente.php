<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_cliente',
        'apellido_cliente',
        'nombre_empresa',
    ];

    public function user()
{
    return $this->hasOne(User::class, 'id');
}
}
