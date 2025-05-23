<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StrengthHistory extends Model
{
    use SoftDeletes;

    protected $table = 'strength_history';

    protected $fillable = [
        'id_alumno',
        'historial_preguntas',
        'estados_fortaleza',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
