<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuricataImportState extends Model
{
    protected $table = 'suricata_import_state';

    protected $fillable = [
        'file_path',
        'file_inode',
        'file_offset',
    ];

    protected $casts = [
        'file_offset' => 'integer',
    ];
}