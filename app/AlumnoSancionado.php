<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class AlumnoSancionado extends Model
{

    protected $table = 'alumnosancionado';
    protected $primaryKey = 'id';
    public $timestamps = true; // Si no tienes timestamps en tu tabla programas
    /* SoftDeletes, esto sirve para dar un mantenimiento a la base de datos saber cuando sea editado o eliminado */
    use SoftDeletes;
        protected $fillable = [
            'alumno_id',
            'motivo',
            'fecha_desde',
            'fecha_vigencia',
            'estado',
        ];


     public function alumno()
    {
        return $this->belongsTo(Alumno::class, 'alumno_id'); // Ajusta el nombre de la clave foránea si es diferente
    }
    
}
