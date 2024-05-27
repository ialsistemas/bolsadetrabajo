<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Educacion extends Model
{
    use SoftDeletes;

    protected $fillable = [
       'alumno_id', 'institucion', 'carrera_curso', 'area_id', 'estado', 'estudio_inicio', 'estudio_fin', 'ciclo', 'estado_estudiante', 'anio'
    ];

    protected $dates = ['deleted_at'];

    function alumnos()
    {
        return $this->belongsTo('\BolsaTrabajo\Alumno', 'alumno_id');
    }

    function areas()
    {
        return $this->belongsTo('\BolsaTrabajo\Area', 'area_id');
    }

}
