<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnuncioEmpresa extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'titulo','enlace','mostrar','vigencia','banner'
    ];
}
