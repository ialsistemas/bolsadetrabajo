<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Grado_academico;
use BolsaTrabajo\Estado;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\Estudiante_aviso;
use BolsaTrabajo\Intermediacion_seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AvisoPostulacionController extends Controller
{
    public function index()
    {
        return view('auth.aviso-postulacion.index', ['Empresas' => Empresa::all(), 'Areas' => Area::all(), 'Provincias' => Provincia::all(), 'GradoAcademico' => Grado_academico::all() ]);
    }

    public function list(Request $request)
    {
        if($request->mostrar == 'todo'){
            $alumno = Alumno::select('alumnos.id', 
            'alumno_avisos.created_at as fecha_postulacion',
            'alumnos.nombres', 
            'alumnos.apellidos', 
            'alumnos.dni', 
            'alumnos.email', 
            'alumnos.telefono',
            'avisos.titulo',
            'areas.nombre as carrera',
            'empresas.ruc',
            'empresas.nombre_comercial',
            'grado_academicos.grado_estado as grado_academico',
            'estados.nombre as estado')
            ->join('alumno_avisos', 'alumno_avisos.alumno_id', '=', 'alumnos.id')
            ->join('avisos', 'avisos.id', '=', 'alumno_avisos.aviso_id')
            ->join('empresas', 'empresas.id', '=', 'avisos.empresa_id')
            ->join('estados', 'estados.id', '=', 'alumno_avisos.estado_id')
            ->join('grado_academicos','grado_academicos.id','=','alumnos.egresado')
            ->join('distritos','distritos.id','=','alumnos.distrito_id')
            ->join('areas','areas.id','=','alumnos.area_id')
            ->where('alumnos.deleted_at', NULL)
            ->where('avisos.deleted_at', NULL)
            ->distinct()
            ->orderBy('alumno_avisos.created_at', 'DESC')
            ->get();
        }else{
            $alumno = Alumno::select('alumnos.id', 
            'alumno_avisos.created_at as fecha_postulacion',
            'alumnos.nombres', 
            'alumnos.apellidos', 
            'alumnos.dni', 
            'alumnos.email', 
            'alumnos.telefono',
            'avisos.titulo',
            'areas.nombre as carrera',
            'empresas.ruc',
            'empresas.nombre_comercial',
            'grado_academicos.grado_estado as grado_academico',
            'estados.nombre as estado')
            ->join('alumno_avisos', 'alumno_avisos.alumno_id', '=', 'alumnos.id')
            ->join('avisos', 'avisos.id', '=', 'alumno_avisos.aviso_id')
            ->join('empresas', 'empresas.id', '=', 'avisos.empresa_id')
            ->join('estados', 'estados.id', '=', 'alumno_avisos.estado_id')
            ->join('grado_academicos','grado_academicos.id','=','alumnos.egresado')
            ->join('distritos','distritos.id','=','alumnos.distrito_id')
            ->join('areas','areas.id','=','alumnos.area_id')
            ->whereDate('alumno_avisos.created_at', '>=', $request->desde)
            ->whereDate('alumno_avisos.created_at', '<=', $request->hasta)
            ->where('alumnos.area_id', 'like', '%'.$request->carrera.'%')
            ->where('alumnos.provincia_id', 'like', '%'.$request->provincia.'%')
            ->where('alumnos.egresado', 'like', '%'.$request->tipo_estudiante.'%')
            ->where('alumnos.deleted_at', NULL)
            ->where('avisos.deleted_at', NULL)
            ->distinct()
            ->orderBy('alumno_avisos.created_at', 'DESC')
            ->get();
        }
        return response()->json(['data' => $alumno]);
    }

    public function partialViewPostulantes($id)
    {
        return view('auth.aviso._Postulantes', ['id' => $id]);
    }

    public function partialViewPostulantesEstudiantes(Request $request)
    {
        return response()->json(['data' =>  Estudiante_aviso::where('aviso_id', $request->id)->where('deleted_at', NULL)->get() ]);
    }

    public function list_postulantes(Request $request)
    {
        return response()->json(['data' => AlumnoAviso::with('alumnos')->with('estados')->where('aviso_id', $request->id)->get() ]);
    }

    public function partialEditarEstados($idalumno, $idaviso)
    {
        $estado = Estado::all();
        $alumno_avisos = AlumnoAviso::where('alumno_id', $idalumno)->where('aviso_id', $idaviso)->get();
        return view('auth.aviso._EditarEstado', ['alumno_avisos' => $alumno_avisos, 'idalumno' => $idalumno, 'idaviso' => $idaviso, 'estado' => $estado]);
    }
}
