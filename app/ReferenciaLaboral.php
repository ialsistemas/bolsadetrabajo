<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReferenciaLaboral extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'alumno_id', 'name_curso', 'institucion', 'inicio_curso', 'fin_curso'
    ];

    protected $dates = ['deleted_at'];

    function alumnos()
    {
        return $this->belongsTo('\BolsaTrabajo\Alumno', 'alumno_id');
    }
}
