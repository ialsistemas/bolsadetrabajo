<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuracion extends Model
{
    protected $table = 'configuracion'; // Nombre de la tabla
    use SoftDeletes;

    protected $fillable = [
        'nombre','email','web','tel','logo','facebook','instagram','linkedin',
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

}
