<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParticipantesEmpleabilidad extends Model
{


    protected $table = 'participantes_empleabilidad';
    protected $primaryKey = 'id_participante';
    public $timestamps = false;

    use SoftDeletes;

    protected $fillable = [
        'id_participante',
        'dni',
        'nombres',
        'apellidos',
        'email',
        'tel',
        'estado',
        'tipo',
        'sede',
        'especialidad',
        'id_programa',
    ];

    public function programa()
    {
        return $this->belongsTo(ProgramaEmpleabilidad::class, 'id_programa', 'id');
    }
}
