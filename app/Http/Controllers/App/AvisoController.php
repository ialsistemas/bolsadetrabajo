<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Grado_academico;
use BolsaTrabajo\ExperienciaLaboral;
use BolsaTrabajo\Estudiante_aviso;
use BolsaTrabajo\ReferenciaLaboral;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Estado;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\Horario;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Modalidad;
use BolsaTrabajo\Provincia;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PDF;

class AvisoController extends Controller
{
    protected $avisos_per_page = 20;

    public function avisos(Request $request)
    {
        if($request->ajax()) {

            $Perfil = Auth::guard('alumnos')->user() ? App::$PERFIL_ALUMNO : App::$PERFIL_EMPRESA;
            $Avisos = Aviso::orderBy('id', 'desc')
                ->whereHas('empresas', function ($q){ $q->where('deleted_at', null);  })
                ->where(function ($q) use ($request){ if($request->name){ $q->where('titulo', 'like', '%'.$request->name. '%'); } })
                ->where(function ($q) use ($Perfil, $request){ if(in_array($Perfil, [App::$PERFIL_EMPRESA])){ $q->where('empresa_id', Auth::guard('empresasw')->user()->id); } })
                ->where(function ($q) use ($request){ if($request->fecha_inicio){ $q->whereDate('created_at', '>=', $request->fecha_inicio);}})
                ->where(function ($q) use ($request){ if($request->fecha_final){ $q->whereDate('created_at', '<=', $request->fecha_final);}})
                /* ->where(function ($q) use ($request){ if($request->provincia_id){ $q->where('provincia_id', $request->provincia_id);}}) */
                ->where(function ($q) use ($request){ if($request->distrito_id){ $q->where('distrito_id', $request->distrito_id);}})
                ->where('estado_aviso', 1)
                ->where('solicita_grado_a', 'like', '%'.$request->tipo_estudiante.'%')
                // ->where(function ($q) use ($request){ if($request->horario_id){ $q->where('horario_id', $request->horario_id);}})
                // ->where(function ($q) use ($request){ if($request->modalidad_id){ $q->where('modalidad_id', $request->modalidad_id);}})

                // ->where(function ($q) use ($request){ if($request->vacantes){ $q->where('vacantes', $request->vacantes);}})
                // ->where(function ($q) use ($request){ if($request->solicita_carrera){ $q->where('solicita_carrera', $request->solicita_carrera);}})
                // ->where(function ($q) use ($request){ if($request->solicita_grado_a){ $q->where('solicita_grado_a', $request->solicita_grado_a);}})
                // ->where(function ($q) use ($request){ if($request->periodo_vigencia){ $q->where('periodo_vigencia', $request->periodo_vigencia);}})

                //->where(function ($q) use ($request){ if($request->area_id){ $q->where('area_id', $request->area_id);}})
                ->paginate($this->avisos_per_page);
            $carrera = Area::all();
            
            return [
                'avisos' => view('app.avisos.ajax.listado')->with(['carrera' => $carrera, 'avisos' => $Avisos, 'i' => ($this->avisos_per_page*($Avisos->currentPage()-1)+1) ])->render(),
                'next_page' => $Avisos->nextPageUrl()
            ];
        }

        $Areas = Area::orderby('nombre', 'asc')->get();
        $Provincias = Provincia::orderby('nombre', 'asc')->get();
        $Horarios = Horario::orderby('nombre', 'asc')->get();
        $Modalidades = Modalidad::orderby('nombre', 'asc')->get();
        $Anuncio = Anuncio::where('vigencia', '>=', date('Y-m-d'))->where('mostrar', '<=', date('Y-m-d'))->orderby('created_at', 'desc')->get();        
        $Grado_academico = Grado_academico::all();
        // Obtener todos los alumnos y seleccionar la columna 'aprobado'
        $Alumno = Auth::guard('alumnos')->user();


        return view('app.avisos.index', [
            'areas' => $Areas,
            'provincias' => $Provincias,
            'horarios' => $Horarios,
            'modalidades' => $Modalidades,
            'anuncio' => $Anuncio,
            'grado_academico' => $Grado_academico,
            'alumno' => $Alumno  // Pasar los alumnos a la vista
        ]);
    }

    public function informacion($empresa, $slug)
    {
        /* $Aviso = Aviso::where('link', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('link',  $empresa);})->first(); */
        $Aviso = Aviso::where('id', $slug)
        ->whereHas('empresas', function ($q) use ($empresa){ $q->where('id',  $empresa);})->first();

        $AlumnosAvisos = AlumnoAviso::where('aviso_id', $Aviso->id)->get();

        if(!Auth::guard('alumnos')->check()){
            if($Aviso!= null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id){
                return view('app.avisos.informacion', ['aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos]);
            }
            return redirect(route('index'));
        }

        $AlumnosAviso = $AlumnosAvisos->where('alumno_id', Auth::guard('alumnos')->user()->id)->first();

        return view('app.avisos.informacion', ['aviso' => $Aviso, 'alumnoAviso' => $AlumnosAviso]);
    }

    public function postular(Request $request)
    {
        $status = false; $redirect = null;

        $errors = Alumno::ValidatePerfilAlumno();

        if(count($errors) > 0){
            $redirect = route('alumno.perfil');
        }else{
            $Alumno = Auth::guard('alumnos')->user()->id;
            $AlumnoAvisos = AlumnoAviso::where('alumno_id', $Alumno)->where('aviso_id', $request->aviso_id)->first();
            if(!$AlumnoAvisos){
                AlumnoAviso::create([
                    'alumno_id' => $Alumno,
                    'aviso_id' => $request->aviso_id,
                    'estado_id' => App::$ESTADO_POSTULANTES
                ]);
                $status = true;
            }
        }

        return response()->json(['Success' => $status, 'Redirect' => $redirect]);
    }

    // aca
    public function postulantes($empresa, $slug)
    {
        $Educacion = Educacion::all();
        $Area = Area::all();
        $Distrito = Distrito::all();
        $Grado_academico = Grado_academico::all();
        /* $Aviso = Aviso::where('link', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('link',  $empresa);})->first(); */
        $Aviso = Aviso::where('id', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('id',  $empresa);})->first();

        $AlumnosAvisos = AlumnoAviso::with('alumnos')->where('aviso_id', $Aviso->id)->get();

        if(!Auth::guard('alumnos')->user()){
            if($Aviso!= null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id){

                return view('app.avisos.postulantes', ['aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos, 'postulantes' => $AlumnosAvisos, 
                "Educacion"=>$Educacion, "area"=>$Area, "Distrito"=>$Distrito, "Grado_academico"=>$Grado_academico]);
            }
        }
        return redirect(route('index'));
    }

    public function postulante_informacion($empresa, $slug, $alumno)
    {
        /* $Aviso = Aviso::where('link', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('link',  $empresa);})->first(); */
        $Aviso = Aviso::where('id', $slug)->whereHas('empresas', function ($q) use ($empresa){ $q->where('id',  $empresa);})->first();
        $Alumno = Alumno::where('usuario_alumno', $alumno)->first();
        $updateEstado = AlumnoAviso::where('alumno_id', $Alumno->id)->where('aviso_id', $slug)->update(['estado_id' => 2]);
        $Estados = Estado::whereIn('id', [2,4,5])->get();
        $AlumnosAvisos = AlumnoAviso::with('alumnos')->where('aviso_id', $Aviso->id);
        $Postulante = $AlumnosAvisos->where('alumno_id', $Alumno->id)->first();
        $Educaciones = Educacion::where('alumno_id', $Alumno->id)->get();
        $Area = Area::all();

        if(!Auth::guard('alumnos')->user() && $Postulante){
            if($Aviso!= null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id){
                $AlumnosAvisos = $AlumnosAvisos->get();
                return view('app.avisos.postulante_informacion', ['area' => $Area, 'educaciones' => $Educaciones, 'aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos, 'alumno' => $Alumno, 'postulante' => $Postulante, 'estados' => $Estados]);
            }
        }
        return redirect(route('index'));
    }

    // function hecho por marco
    public function donwloadCValumno($empresa, $slug, $alumno){

        $Alumno = Alumno::where('id', $alumno)->first();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('id', $Alumno->distrito_id)->get();
        $Educaciones = Educacion::where('alumno_id', $alumno)->get();
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $alumno)->get();
        $Educaciones = Educacion::where('alumno_id', $alumno)->get();

        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->get();

        $pdf = PDF::loadView('app.avisos.cv_postulado',  ['referenciaLaboral' => $ReferenciaLaboral,'provincias' => $Provincias, 'areas' => $Areas, 'alumno' => $Alumno, "experienciaLaboral" => $ExperienciaLaboral, "educaciones" => $Educaciones, 'distritos' => $Distritos]);
        return $pdf->stream();

    }    
    
    public function clasificar_aviso(Request $request)
    {
        AlumnoAviso::where('alumno_id', $request->alumno_id)->where('aviso_id', $request->aviso_id)
            ->update(['estado_id' => $request->estado_id]);

        $AlumnosAvisos = AlumnoAviso::where('aviso_id', $request->aviso_id)->get();

        $Postulados = count($AlumnosAvisos->where('estado_id', App::$ESTADO_POSTULANTES)->pluck('aviso_id')->toArray());
        $Evaluados = count($AlumnosAvisos->where('estado_id', App::$ESTADO_EVALUANDO)->pluck('aviso_id')->toArray());
        $Seleccionados = count($AlumnosAvisos->where('estado_id', App::$ESTADO_SELECCIONADOS)->pluck('aviso_id')->toArray());
        $Aceptados = count($AlumnosAvisos->where('estado_id', App::$ESTADO_ACEPTADOS)->pluck('aviso_id')->toArray());
        $Descartados = count($AlumnosAvisos->where('estado_id', App::$ESTADO_DESCARTADOS)->pluck('aviso_id')->toArray());

        return response()->json(['Success' => true, 'postulados' => $Postulados, 'evaluados' => $Evaluados,
            'seleccionados' => $Seleccionados, 'aceptados' => $Aceptados, 'descartados' => $Descartados ]);
    }

    public function empresa_informacion($slug)
    {
        return view('app.empresas.informacion', ['Empresa' => Empresa::where('link', $slug)->first()]);
    }

    public function delete(Request $request){

        $status = false; $message = null;

        $entity = Aviso::find($request->id);

        if($entity->empresa_id == Auth::guard('empresasw')->user()->id)
            if($entity->delete()) $status = true;
            else
                $message = "No tiene permisos para realizar esta acción";

        return response()->json(['Success' => $status, 'Message' => $message]);
    }

}