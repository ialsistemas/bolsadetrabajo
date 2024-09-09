<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Eventos extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'fecha_registro','nombre'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function eventosasistencia()
    {
        return $this->hasMany(EventosAsistencia::class, 'id_evento', 'id');
    }
      
}
