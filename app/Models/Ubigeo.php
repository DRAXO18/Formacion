<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubigeo extends Model
{
    use HasFactory;

    protected $table = 'ubigeo';

    protected $fillable = [
        'codigo_postal',
        'departamento',
        'distrito',
        'provincia'
    ];

    public function tiendas()
    {
        return $this->hasMany(Tienda::class, 'id_ubigeo');
    }
}
