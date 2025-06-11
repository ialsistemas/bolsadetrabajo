<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostulacionAlumnoAvisoFeria extends Model
{
    use SoftDeletes;
    protected $table = 'postulacion_alumno_aviso_feria';
    protected $fillable = [
        'id_feria',
        'id_aviso_feria',
        'dni_alumno',
        'state',
        'created_at',
        'updated_at',
        'deleted_modified_by',
        'deleted_at',
    ];
}
