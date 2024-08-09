<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'view_name', 'view_params'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
