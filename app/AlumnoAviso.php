<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;

class AlumnoAviso extends Model
{
    protected $fillable = [
        'alumno_id', 'aviso_id', 'estado_id'
    ];

    function alumnos()
    {
        return $this->belongsTo('\BolsaTrabajo\Alumno', 'alumno_id');
    }

    function avisos()
    {
        return $this->belongsTo('\BolsaTrabajo\Aviso', 'aviso_id');
    }

    function estados()
    {
        return $this->belongsTo('\BolsaTrabajo\Estado', 'estado_id');
    }
}
