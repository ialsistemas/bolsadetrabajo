<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inteligencias extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'preguntas_selecionadas',
        'descripcion_simple',
        'created_at',
        'updated_at',
        'deleted_modified_by',
        'deleted_at',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
