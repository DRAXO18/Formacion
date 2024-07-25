<?php

// app/Models/Cliente.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'users';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}

