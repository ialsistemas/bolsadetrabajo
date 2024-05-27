<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;

class AlumnoHabilidad extends Model
{
    protected $fillable = [
        'alumno_id', 'habilidad_id'
    ];

    public $timestamps = false;

    function alumnos()
    {
        return $this->belongsTo('\BolsaTrabajo\Alumno', 'alumno_id');
    }

    function habilidades()
    {
        return $this->belongsTo('\BolsaTrabajo\Habilidad', 'habilidad_id');
    }

}
