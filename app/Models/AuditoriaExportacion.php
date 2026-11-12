<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditoriaExportacion extends Model
{
    protected $table = 'auditoria_exportaciones';

    public $timestamps = false;

    protected $fillable = [
        'usuario_id',
        'nombre_usuario',
        'tipo_usuario',
        'ip',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}