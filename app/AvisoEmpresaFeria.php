<?php

namespace BolsaTrabajo;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AvisoEmpresaFeria extends Model
{
    use SoftDeletes;
    protected $table = 'aviso_empresa_feria';
    protected $fillable = [
        'id_feria',
        'ruc_empresa',
        'name',
        'description',
        'requisitos',
        'url_zoom',
        'route',
        'created_at',
        'updated_at',
        'deleted_modified_by',
        'deleted_at',
    ];
}
