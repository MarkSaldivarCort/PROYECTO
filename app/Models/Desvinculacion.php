<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empleado;
use App\Models\Usuarios;

class Desvinculacion extends Model
{
    protected $table = 'desvinculaciones';

    public $timestamps = false;

    protected $fillable = [
        'empleado_id',
        'motivo',
        'fecha_baja',
        'observaciones',
        'responsable_id',
        'finiquito',
    ];

    protected $casts = [
        'fecha_baja' => 'date',
        'finiquito' => 'decimal:2',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'empleado_id');
    }

    public function responsable()
    {
        return $this->belongsTo(Usuarios::class, 'responsable_id');
    }
}
