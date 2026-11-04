<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'rfc',
        'curp',
        'nss',
        'puesto',
        'departamento',
        'salario',
        'email',
        'telefono',
        'estatus',
        'fecha_ingreso',
        'fecha_baja'
    ];

    protected function casts(): array
    {
        return [
            'salario' => 'decimal:2',
            'fecha_ingreso' => 'date',
            'fecha_baja' => 'date',
        ];
    }
}