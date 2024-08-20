<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\Grado_academico;
use BolsaTrabajo\Estado;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Estudiante_aviso;
use BolsaTrabajo\Intermediacion_seguimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AvisoController extends Controller
{
    public function index()
    {
        return view('auth.aviso.index', ['Empresas' => Empresa::all()]);
    }

    /* public function list_old(Request $request)
    {
        if($request->mostrar == 'mostrarTodo'){
            return response()->json(['data' => Aviso::whereHas('empresas', function ($q) { $q->where('deleted_at',  null);})
            ->with('empresas')->with('provincias')->with('areas')
            ->with('modalidades')->with('horarios')->with('provincias')
            ->with('distritos')
            ->orderBy('avisos.created_at', 'DESC')
            ->get()
            ]);
        }else if($request->mostrar == 'mostrarPendientes'){
            return response()->json(['data' => Aviso::whereHas('empresas', function ($q) { $q->where('deleted_at',  null);})
            ->where('estado_aviso', false)
            ->with('empresas')->with('provincias')->with('areas')
            ->with('modalidades')->with('horarios')->with('provincias')
            ->with('distritos')
            ->orderBy('avisos.created_at', 'DESC')
            ->get()
            ]);
        }else if(isset($request->ruc_dni)){
            return response()->json(['data' => Aviso::whereHas('empresas', function ($q) { $q->where('deleted_at',  null);})


            ->whereHas('empresas', function ($q) use ($request) { $q->where('ruc', 'like', '%'.$request->ruc_dni.'%' ); })
            ->with('empresas')->with('provincias')->with('areas')
            ->with('modalidades')->with('horarios')->with('provincias')
            ->with('distritos')
            ->orderBy('avisos.created_at', 'DESC')
            ->limit(80)
            ->get()
            ]);
        }else{
            return response()->json(['data' => '' ]);
        }
    } */



    public function list(Request $request)
    {
        // Define la consulta base para Aviso
        $query = Aviso::whereHas('empresas', function ($q) {
            $q->whereNull('deleted_at');
        });

        // Filtra según el tipo de solicitud
        if ($request->mostrar === 'mostrarTodo') {
            // Consulta para mostrar todos los registros
            $avisos = $query
                ->with(['empresas', 'provincias', 'areas', 'modalidades', 'horarios', 'distritos'])
                ->orderBy('created_at', 'DESC')
                ->get();
        } elseif ($request->mostrar === 'mostrarPendientes') {
            // Consulta para mostrar solo los avisos pendientes
            $avisos = $query
                ->where('estado_aviso', false)
                ->with(['empresas', 'provincias', 'areas', 'modalidades', 'horarios', 'distritos'])
                ->orderBy('created_at', 'DESC')
                ->get();
        } elseif (isset($request->ruc_dni)) {
            // Consulta para filtrar por RUC/DNI
            $avisos = $query
                ->whereHas('empresas', function ($q) use ($request) {
                    $q->where('ruc', 'like', '%' . $request->ruc_dni . '%');
                })
                ->with(['empresas', 'provincias', 'areas', 'modalidades', 'horarios', 'distritos'])
                ->orderBy('created_at', 'DESC')
                ->limit(80)
                ->get();
        }elseif (isset($request->fechasemestre) && !empty($request->fechasemestre)) {
            // Extrae el año del select fechasemestre
            $year = $request->fechasemestre;
        
            // Consulta para filtrar por año
            $avisos = $query
                ->whereYear('created_at', $year)
                ->with(['empresas', 'provincias', 'areas', 'modalidades', 'horarios', 'distritos'])
                ->orderBy('created_at', 'DESC')
                ->get();
        }else {
            // Caso por defecto si no se cumple ninguna de las condiciones anteriores
            $avisos = collect(); // Retorna una colección vacía en lugar de una cadena vacía
        }

        // Devuelve la respuesta JSON con los datos obtenidos
        return response()->json(['data' => $avisos]);
    }


    public function partialViewPostulantes($id)
    {
        return view('auth.aviso._Postulantes', ['id' => $id]);
    }

    // codigo hecho por marco
    public function partialViewAviso($id)
    {
        $aviso = Aviso::select('avisos.titulo', 
        'avisos.descripcion' ,
        'avisos.direccion', 
        'avisos.salario', 
        'avisos.created_at as publicado', 
        'distritos.nombre as distrito', 
        'areas.nombre as area', 
        'empresas.nombre_comercial as nombre_empresa')
        ->join('empresas','empresas.id','=','avisos.empresa_id')    
        ->join('distritos', 'distritos.id', '=', 'avisos.distrito_id')
        ->leftjoin('areas', 'areas.id', '=', 'avisos.solicita_carrera')
        ->where('avisos.id', $id)
        ->get();
        return view('auth.aviso._Aviso', ['aviso' => $aviso]);
    }
    // Actualizacion estado aviso
    public function updateEstadoAviso(Request $request)
    {
        $status = false;
        $entity = Aviso::find($request->id);
        $entity->estado_aviso = $request->update_id;
        if($entity->save()) $status = true;
        return response()->json(['Success' => $status]);
    }
    // codigo hecho por marco
    public function partialViewEditarAviso($id)
    {
        $aviso = Aviso::find($id);   
        $distrito = Distrito::all();
        $areas = Area::all();
        $grado = Grado_academico::all();
        return view('auth.aviso._EditarAviso', ['id' => $id, 'aviso' => $aviso, 'distrito' => $distrito, 'areas' => $areas, 'grado' => $grado ]);
    }
    // codigo hecho por marco
    public function update(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'distrito_id' => 'required',
            'vacantes' => 'required',
            'descripcion' => 'required',
            'salario' => 'required',
            'periodo_vigencia' => 'required',
            'solicita_carrera' => 'required',
            'solicita_grado_a' => 'required'
        ]);
        if (!$validator->fails()){
            $entity = Aviso::find($request->id);
            $entity->titulo = $request->titulo;
            $entity->distrito_id = $request->distrito_id;
            $entity->descripcion = $request->descripcion;
            $entity->salario = $request->salario;
            $entity->vacantes = $request->vacantes;
            $entity->solicita_carrera = $request->solicita_carrera;
            $entity->solicita_grado_a = $request->solicita_grado_a;
            $entity->ciclo_cursa = $request->ciclo_cursa;
            $entity->periodo_vigencia = $request->periodo_vigencia;
            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }
    // codigo hecho por marco
    public function partialViewPostulantesEstudiantes2(Request $request)
    {
        return response()->json(['data' =>  Intermediacion_seguimiento::where('aviso_id', $request->id)->where('deleted_at', NULL)->get() ]);
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

    public function updateEstado(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'idalumno' => 'required',
            'idaviso' => 'required',
            'idestado' => 'required'
        ]);
        if (!$validator->fails()){
            $affectedRows = DB::table('alumno_avisos')
                ->where('alumno_id', $request->idalumno)
                ->where('aviso_id', $request->idaviso)
                ->update(['estado_id' => $request->idestado]);
    
            if ($affectedRows > 0) {
                $status = true;
            }           
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Aviso::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }

    // codigo creado por marco
    public function store_estudiante_aviso(Request $request)
    {   
        $status = false;

        $request->merge([
            'aviso_id' => $request->id_estudiante_aviso,
            'nombres'  => $request->nombres_apellido,
            'dni'      => $request->dni,
            'telefono' => $request->celular,
            'correo'   => $request->correo,
            'grado_academico' => $request->grado_academico,
            'estado' => $request->estado
        ]);
        $validator = Validator::make($request->all(), [
            'nombres_apellido' => 'required'
        ]);

        if (!$validator->fails()){
            Estudiante_aviso::create($request->all());
            $status = true;
        }

        return $status ? redirect(route('auth.aviso')) : redirect(route('auth.aviso'))->withErrors($validator)->withInput();

    }

    public function store_seguimiento(Request $request)
    {   
        $status = false;

        $request->merge([
            'aviso_id' => $request->id_aviso_s,
            'fecha_envio_postulantes'  => $request->fecha_envio,
            'fecha_seguimiento'  => $request->fecha_seguimiento,
            'comentarios' => $request->comentario
        ]);
        $validator = Validator::make($request->all(), [
            'aviso_id' => 'required'
        ]);

        if (!$validator->fails()){
            Intermediacion_seguimiento::create($request->all());
            $status = true;
        }

        return $status ? redirect(route('auth.aviso')) : redirect(route('auth.aviso'))->withErrors($validator)->withInput();
        
    }
}