<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificadosAlumnos extends Model
{
    protected $table = 'certificadosalumnos'; // Nombre de la tabla

    use SoftDeletes;

    protected $fillable = [
        'id', 'dni','nombres','apellidos','especialidad','tel','email'
    ];

    public $timestamps = false;

    protected $dates = ['deleted_at'];

    public function certificado()
    {
        return $this->belongsTo(Certificados::class, 'id_certificados');
    }

}
