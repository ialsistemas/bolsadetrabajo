<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsesorasExpress extends Model
{
    use SoftDeletes;
    protected $table = 'asesoras_express';
    protected $fillable = [
        'name',
        'area',
        'description',
        'route',
        'img',
        'created_at',
        'updated_at',
        'deleted_modified_by',
        'deleted_at',
    ];
}
