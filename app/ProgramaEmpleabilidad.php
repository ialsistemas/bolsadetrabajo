<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ProgramaEmpleabilidad extends Model
{

    protected $table = 'programas_empleabilidades';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use SoftDeletes;
    protected $fillable = [
        'registro',
        'tipo_programa',
        'empresa',
        'puestouno',
        'puestouno',
        'puestodos',
        'puestotres',
        'puestocuatro',
        'responsable',
        'postulantes',
        'evaluando',
        'contratados',
        'descartado',
    ];
    public function participantes()
    {
        return $this->hasMany(Participantes::class, 'id_programa', 'id');
    }
}
