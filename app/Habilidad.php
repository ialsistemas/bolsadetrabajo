<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Habilidad extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre', 'tipo'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];
}
