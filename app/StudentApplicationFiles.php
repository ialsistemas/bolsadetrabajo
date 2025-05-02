<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class StudentApplicationFiles extends Model
{

    protected $table = 'student_application_files';
    protected $primaryKey = 'id';
    public $timestamps = false;
    use SoftDeletes;
    protected $fillable = [
        'dni_alumno',
        'id_programa',
        'video_presentation',
        'cv_pdf',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
