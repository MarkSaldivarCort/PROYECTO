<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlertaSuricata extends Model
{
    protected $table = 'alertas_suricata';

    protected $fillable = [
        'flow_id',
        'src_ip',
        'dest_ip',
        'signature',
        'severity',
        'sid',
        'fecha_evento',
        'event_type',
        'http_method',
        'http_url',
        'http_status',
    ];

    protected function casts(): array
    {
        return [
            'fecha_evento' => 'datetime',
            'severity' => 'integer',
            'http_status' => 'integer',
        ];
    }
}

