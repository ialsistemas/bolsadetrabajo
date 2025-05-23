<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IntelligenceHistory extends Model
{
    use SoftDeletes;

    protected $table = 'intelligence_history';

    protected $fillable = [
        'id_alumno',
        'historial_preguntas',
        'estados_inteligencia',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
