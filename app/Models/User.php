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
        'id_rol', // Asegúrate de tener este campo en tu base de datos
    ];

    /**
     * Relación con el tipo de usuario.
     */
    public function tipoUsuario()
    {
        return $this->belongsTo(TipoUsuario::class, 'idtipo_usuario');
    }

    /**
     * Relación con el tipo de documento.
     */
    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'idtipo_documento');
    }

    /**
     * Relación con el rol.
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    /**
     * Verificar si el usuario tiene acceso a un permiso específico.
     */
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
     * Los atributos que deberían estar ocultos para los arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deberían ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
