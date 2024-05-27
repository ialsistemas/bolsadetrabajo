<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\AlumnoHabilidad;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\ExperienciaLaboral;
use BolsaTrabajo\Habilidad;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\ReferenciaLaboral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;

class PostulacionesController extends Controller
{
    public function index()
    {
        $Alumno = Auth::guard('alumnos')->user();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('provincia_id', $Alumno->provincia_id)->get();

        $Educaciones = Educacion::where('alumno_id', $Alumno->id)->get();
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $Alumno->id)->get();
        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->get();
        $Habilidades = AlumnoHabilidad::where('alumno_id', $Alumno->id)
            ->whereHas('habilidades', function ($query) { $query->whereNull('deleted_at'); })
            ->get();

        $postulaciones = AlumnoAviso::select(
            'alumno_avisos.created_at as fecha_postulacion',
            'avisos.created_at as fecha_publicacion',
            'avisos.titulo',
            'avisos.salario',
            'avisos.periodo_vigencia',
            'empresas.nombre_comercial',
            'empresas.ruc',
            'estados.nombre as estado_postulacion')
            ->join('avisos','avisos.id','=','alumno_avisos.aviso_id')
            ->join('empresas','empresas.id','=','avisos.empresa_id')
            ->join('estados','estados.id','=','alumno_avisos.estado_id')
            ->join('alumnos','alumnos.id','=','alumno_avisos.alumno_id')
            ->where('alumno_avisos.alumno_id', $Alumno->id)
            ->where('avisos.deleted_at', NULL)
            ->orderBy('fecha_postulacion', 'DESC')
            ->get();

        $postulaciones_count = AlumnoAviso::select(
            'alumno_avisos.created_at as fecha_postulacion',
            'avisos.created_at as fecha_publicacion',
            'avisos.titulo',
            'avisos.salario',
            'empresas.nombre_comercial',
            'empresas.ruc',
            'estados.nombre as estado_postulacion')
            ->join('avisos','avisos.id','=','alumno_avisos.aviso_id')
            ->join('empresas','empresas.id','=','avisos.empresa_id')
            ->join('estados','estados.id','=','alumno_avisos.estado_id')
            ->join('alumnos','alumnos.id','=','alumno_avisos.alumno_id')
            ->where('alumno_avisos.alumno_id', $Alumno->id)
            ->where('avisos.deleted_at', NULL)
            ->get()
            ->count();

        $Anios =  range(date('Y'), date('Y')-21);
        array_push($Anios, "En Curso");

        $errors = Alumno::ValidatePerfilAlumno();

        return view('app.postulaciones.index', ['postulaciones' => $postulaciones, 'postulaciones_count' => $postulaciones_count, 'Alumno' => $Alumno]);
    }

}
