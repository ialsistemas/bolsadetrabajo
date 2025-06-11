<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feria extends Model
{
    use SoftDeletes;
    protected $table = 'feria';
    protected $fillable = [
        'name',
        'fecha_inicio',
        'fecha_final',
        'route',
        'deleted_modified_by',
        'deleted_at',
    ];
}
