<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasApiTokens, Notifiable;

    // Los atributos que son asignables en masa
    protected $fillable = [
        'nombre',
        'apellido',
        'numero_identificacion',
        'idtipo_documento',
        'idtipo_usuario',
        'email',
        'password',
        'foto',
        'id_rol',
    ];

    // Las relaciones
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'idtipo_usuario');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'idtipo_documento');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function billetera()
    {
        return $this->hasOne(Billetera::class);
    }

    // Verificar acceso a permisos
    public function hasAcceso($acceso)
    {
        foreach ($this->roles as $role) {
            if ($role->accesos->contains('nombre', $acceso)) {
                return true;
            }
        }
        return false;
    }

    // Atributos ocultos
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversión de atributos
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Verificar si el usuario ha verificado su email.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return $this->email_verified_at !== null;
    }
}

