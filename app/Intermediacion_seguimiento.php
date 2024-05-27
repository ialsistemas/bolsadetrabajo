<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;

class Intermediacion_seguimiento extends Model
{
    protected $fillable = [
        'aviso_id', 'fecha_envio_postulantes', 'fecha_seguimiento', 'comentarios'
    ];
    function avisos()
    {
        return $this->belongsTo('\BolsaTrabajo\Aviso', 'aviso_id');
    }

}
