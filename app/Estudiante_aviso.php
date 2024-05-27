<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;

class Estudiante_aviso extends Model
{
    protected $fillable = [
        'aviso_id', 'nombres', 'dni', 'telefono', 'correo', 'grado_academico', 'estado', 'comentario'
    ];
    function avisos()
    {
        return $this->belongsTo('\BolsaTrabajo\Aviso', 'aviso_id');
    }

}
