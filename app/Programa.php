<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Programa extends Model
{

    /* SoftDeletes, esto sirve para dar un mantenimiento a la base de datos saber cuando sea editado o eliminado */
    use SoftDeletes;

   /*  protected $guard = 'alumnos'; */
   /*  public $timestamps = false; */
        protected $fillable = [
            'registro',
            'tipo_programa',
            // Aquí puedes agregar otros campos que deseas permitir para asignación masiva
            'empresa',
            'puestouno',
            'puestouno',
            'puestodos',
            'puestotres',
            'puestocuatro',
            'responsable',

            'postulantes',
            'evaluando',
            'contratados',
            'descartado',



            /* 'dni',
            'nombres',
            'apellidos',
            'tel',
            'email',
            'sede',
            'tipo',
            'estado', */
            // Otros campos
        ];
    
        // Resto del código del modelo
    
}
