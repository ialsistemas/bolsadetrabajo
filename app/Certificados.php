<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificados extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre','fecha','horas', 'creditos'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function alumnos()
    {
        return $this->hasMany(CertificadosAlumnos::class, 'id_certificados');
    }
}
