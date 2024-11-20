<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventosAsistencia extends Model
{
    protected $table = 'eventosasistencia';
    protected $primaryKey = 'id';
    public $timestamps = false; // Si no tienes timestamps en tu tabla participantes

    use SoftDeletes;

    protected $fillable = [
        'id',
        'id_evento', // Asegúrate de tener el campo id_programa en fillable si es necesario
        'dni',
        'nombres',
        'apellidos',
        'email',
        'tel',
        'estado',
        'tipo',
        'sede',
        'especialidad',
        'id_user',
        'ciclo'
        
    ];
    
    public function evento()
    {
        return $this->belongsTo(Eventos::class, 'id_evento');
    }


    protected $dates = ['deleted_at'];
}
