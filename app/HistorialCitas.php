<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HistorialCitas extends Model
{
    public $timestamps = false;
    use SoftDeletes;
    protected $table = 'historial_citas';
    protected $fillable = [
        'id_asesora',
        'dni',
        'motivo',
        'dia',
        'hora',
        'state',
        'phone',
        'created_at',
        'updated_at',
        'deleted_modified_by',
        'deleted_at',
    ];
}
