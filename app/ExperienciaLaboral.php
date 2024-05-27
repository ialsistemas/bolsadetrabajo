<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienciaLaboral extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'alumno_id', 'empresa', 'puesto', 'area_id', 'personas_a_cargo', 'desde_mes', 'desde_anio', 'hasta_mes', 'sector', 'descripcion'
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
