<?php

namespace App\Models;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuarios extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    protected $table = 'usuarios';
    protected $fillable = [
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'nombre_de_usuario',
        'password',
        'tipo_usuario',
    ];
}
