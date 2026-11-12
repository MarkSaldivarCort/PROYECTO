<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloqueoExportacion extends Model
{
    protected $table = 'bloqueos_exportacion';

    protected $fillable = [
        'usuario_id',
        'ip',
        'motivo',
        'bloqueado_hasta',
    ];

    protected $casts = [
        'bloqueado_hasta' => 'datetime',
    ];
}