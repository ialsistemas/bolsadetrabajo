<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referencia extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'alumno_id', 'nombres', 'apellidos', 'empresa', 'cargo', 'email', 'telefono'
    ];

    protected $dates = ['deleted_at'];
}
