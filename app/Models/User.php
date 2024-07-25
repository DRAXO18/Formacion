<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identificacion',
        'idtipo_documento',
        'idtipo_usuario',
        'email',
        'password',
        'foto',
    ];

    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'idtipo_usuario');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'idtipo_documento');
    }

    public function hasAcceso($acceso)
    {
        foreach ($this->roles as $role) {
            if ($role->accesos->contains('nombre', $acceso)) {
                return true;
            }
        }
        return false;
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
