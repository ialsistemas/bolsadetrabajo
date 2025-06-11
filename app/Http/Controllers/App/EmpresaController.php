<?php

namespace BolsaTrabajo\Http\Controllers\App;

use Carbon\Carbon;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Feria;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Horario;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Condicion;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\Modalidad;
use BolsaTrabajo\Provincia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\AnuncioEmpresa;
use BolsaTrabajo\Grado_academico;
use Illuminate\Support\Facades\DB;
use BolsaTrabajo\AvisoEmpresaFeria;
use BolsaTrabajo\ReferenciaLaboral;
use BolsaTrabajo\ExperienciaLaboral;
use Illuminate\Support\Facades\Auth;
use BolsaTrabajo\Actividad_economica;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\Http\Controllers\Controller;
use BolsaTrabajo\PostulacionAlumnoAvisoFeria;
use Illuminate\Contracts\Encryption\DecryptException;
use PDF;

class EmpresaController extends Controller
{
    protected $avisos_per_page = 40;

    public function avisos(Request $request)
    {
        if ($request->ajax()) {

            $Avisos = Aviso::where('empresa_id', Auth::guard('empresasw')->user()->id)
                ->orderBy('id', 'asc')->paginate($this->avisos_per_page);

            return [
                'avisos' => view('app.empresa.avisos.ajax.listado')->with(['avisos' => $Avisos, 'i' => ($this->avisos_per_page * ($Avisos->currentPage() - 1) + 1)])->render(),
                'next_page' => $Avisos->nextPageUrl()
            ];
        }
        $Anuncio = Anuncio::where('vigencia', '>=', date('Y-m-d'))->where('mostrar', '<=', date('Y-m-d'))->orderby('created_at', 'desc')->get();

        return view('app.avisos.index');
    }

    public function index()
    {
        $Empresa = Auth::guard('empresasw')->user();
        $ActividadEconomica = Actividad_economica::all();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('provincia_id', $Empresa->provincia_id)->orderby('nombre', 'asc')->get();
        $Cargos = Cargo::all();

        return view('app.empresas.index', ['Areas' => $Areas, 'Provincias' => $Provincias, 'Distritos' => $Distritos, 'Cargos' => $Cargos, 'Empresa' => $Empresa, 'ActividadEconomica' => $ActividadEconomica]);
    }

    public function store(Request $request)
    {
        $status = false;
        $Empresa = Auth::guard('empresasw')->user();
        $request->merge([
            'link' => Str::slug($request->nombre_comercial),
        ]);
        if (!$request->hasFile('img_logo')) {
            return response()->json(['Success' => $status, 'Errors' => "Debes subir un logo de la empresa."]);
        }
        $file = $request->file('img_logo');
        $filename = uniqid('img_') . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('app/img/logo_empresas'), $filename);
        $validator = Validator::make($request->all(), [
            'link' => 'required|unique:empresas,link,' . ($Empresa->id != 0 ? $Empresa->id : "NULL") . ',id,deleted_at,NULL',
        ]);
        if (!$validator->fails()) {
            $Empresa = Empresa::find($Empresa->id);
            $Empresa->razon_social = $request->razon_social;
            $Empresa->nombre_comercial = $request->nombre_comercial;
            $Empresa->actividad_economica_empresa = $request->actividad_economica;
            $Empresa->link = $request->link;
            $Empresa->provincia_id = $request->provincia_id;
            $Empresa->distrito_id = $request->distrito_id;
            $Empresa->direccion = $request->direccion;
            $Empresa->referencia = $request->referencia;
            $Empresa->telefono = $request->telefono;
            $Empresa->email = $request->email;
            $Empresa->pagina_web = $request->pagina_web;
            $Empresa->logo = $filename;
            $Empresa->nombre_contacto = $request->nombre_contacto;
            $Empresa->apellido_contacto = $request->apellido_contacto;
            $Empresa->cargo_contacto = $request->cargo_contacto;
            $Empresa->telefono_contacto = $request->telefono_contacto;
            $Empresa->email_contacto = $request->email_contacto;

            $Empresa->nombre_paciente = $request->name_paciente;
            $Empresa->enfermedad_paciente = $request->enfermedad_paciente;
            $Empresa->evidencias_paciente = $request->carga_evidencias;

            if ($Empresa->save()) {
                if ($request->file('logo') != null)
                    $request->file('logo')->move('uploads/empresas/logos', $logo);

                $status = true;
            }
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }
    public function registrar_aviso()
    {
        $Empresa = Auth::guard('empresasw')->user();
        $Areas = Area::all();
        $Modalidades = Modalidad::all();
        $Condiciones = Condicion::all();
        $Horarios = Horario::all();
        // $Distritos = Distrito::all();
        $Grado = Grado_academico::all();
        $TipoPersona = Empresa::all();

        $Provincias = Provincia::all();
        $Distritos = Distrito::where('provincia_id', $Empresa->provincia_id)->orderby('nombre', 'asc')->get();


        return view('app.avisos.registrar', [
            'Areas' => $Areas, 'Modalidades' => $Modalidades,
            'Condiciones' => $Condiciones, 'Horarios' => $Horarios, 'Distritos' => $Distritos, 'Grado' => $Grado, 'TipoPersona' => $TipoPersona, 'Provincias' => $Provincias
        ]);
    }

    public function store_aviso(Request $request)
    {
        $status = false;

        $request->merge([
            'empresa_id' => Auth::guard('empresasw')->user()->id,
            'titulo' => strtoupper($request->titulo),
            'link' => Str::slug($request->titulo),
            'area_id' => 1,
            'vacantes' => $request->vacantes,
            'solicita_carrera' => $request->solicita_carrera,
            'solicita_grado_a' => $request->solicita_grado_a,
            'ciclo_cursa' => $request->ciclo_cursa,
            'periodo_vigencia' => $request->periodo_vigencia,
            'referencia_direccion' => $request->referencia_direccion,
            'direccion' => $request->direccion
        ]);

        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required',
            'titulo' => 'required',
            // 'link' => ['required','unique:avisos,link,'.($request->id != 0 ? $request->id : "NULL").',id,empresa_id,'.$request->empresa_id.',deleted_at,NULL'],
            //'area_id' => 'required',
            // 'modalidad_id' => 'required',
            // 'horario_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'salario' => 'required',
            'vacantes' => 'required',
            'solicita_carrera' => 'required',
            'solicita_grado_a' => 'required',
            'periodo_vigencia' => 'required'
        ]);

        if (!$validator->fails()) {
            Aviso::create($request->all());
            $status = true;
        }

        return $status ? redirect(route('empresa.avisos')) : redirect(route('empresa.registrar_aviso'))->withErrors($validator)->withInput();
    }


    public function update_aviso(Request $request)
    {
        $status = false;

        $request->merge([
            'empresa_id' => Auth::guard('empresasw')->user()->id,
            'link' => Str::slug($request->titulo),
        ]);

        $validator = Validator::make($request->all(), [
            'empresa_id' => 'required',
            'titulo' => 'required',
            'link' => ['required', 'unique:avisos,link,' . ($request->id != 0 ? $request->id : "NULL") . ',id,empresa_id,' . $request->empresa_id . ',deleted_at,NULL'],
            //'area_id' => 'required',
            // 'modalidad_id' => 'required',
            // 'horario_id' => 'required',
            'distrito_id' => 'required',
            'descripcion' => 'required',
            'salario' => 'required'
        ]);

        if (!$validator->fails()) {
            $entity = Aviso::find($request->id);
            $entity->titulo = $request->titulo;
            $entity->link = $request->link;
            // $entity->modalidad_id = $request->modalidad_id;
            // $entity->horario_id = $request->horario_id;
            $entity->distrito_id = $request->distrito_id;
            $entity->descripcion = $request->descripcion;
            $entity->salario = $request->salario;
            $entity->vacantes = $request->vacantes;
            $entity->solicita_carrera = $request->solicita_carrera;
            $entity->solicita_grado_a = $request->solicita_grado_a;
            $entity->ciclo_cursa = $request->ciclo_cursa;
            $entity->periodo_vigencia = $request->periodo_vigencia;

            if ($entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    //Ajuste simple de feria empresa

    public function listar_aviso()
    {
        $anuncios = AnuncioEmpresa::where('vigencia', '>=', date('Y-m-d'))
            ->where('mostrar', '<=', date('Y-m-d'))
            ->orderBy('created_at', 'desc')
            ->get();
        $listaFeriaData = Feria::where('state', 1)->whereNull('deleted_at')->get();
        return view('app.avisos.listar', ['anuncios' => $anuncios, 'listaFeriaData' => $listaFeriaData]);
    }

    /* Codigo Sebastian */
    /*public function listar_aviso_json(Request $request){
        // Validar y obtener las fechas desde la solicitud
        $fechaDesde = $request->input('fecha_desde', '2000-01-01');
        $fechaHasta = $request->input('fecha_hasta', date('Y-m-d'));

        // Obtener los avisos filtrados por empresa y rango de fechas
        $avisos = Aviso::where('empresa_id', Auth::guard('empresasw')->user()->id)
            ->whereBetween('created_at', [$fechaDesde, $fechaHasta])
            ->with('areas')
            ->with('empresas')
            ->with('modalidades')
            ->with('horarios')
            ->with('provincias')
            ->with('distritos')
            ->get();

        // Retornar los datos en formato JSON
        return response()->json(['data' => $avisos]);
    }*/

    public function listar_aviso_json(Request $request)
    {
        // Validar y obtener las fechas desde la solicitud
        $fechaDesde = $request->input('fecha_desde', '2000-01-01');
        $fechaHasta = $request->input('fecha_hasta', date('Y-m-d'));

        $fechaHoraDesde = $fechaDesde . ' 00:00:00';
        $fechaHoraHasta = $fechaHasta . ' 23:59:59';

        // Obtener los avisos filtrados por empresa y rango de fechas
        $avisos = Aviso::where('empresa_id', Auth::guard('empresasw')->user()->id)
            ->whereBetween('created_at', [$fechaHoraDesde, $fechaHoraHasta])
            ->with('areas')
            ->with('empresas')
            ->with('modalidades')
            ->with('horarios')
            ->with('provincias')
            ->with('distritos')
            ->get();

        // Retornar los datos en formato JSON
        return response()->json(['data' => $avisos]);
    }

    public function partialView_aviso($id)
    {
        $entity = null;

        if ($id != 0) $entity = Aviso::find($id);

        $Areas = Area::all();
        $Modalidades = Modalidad::all();
        $Condiciones = Condicion::all();
        $Horarios = Horario::all();
        $Provincias = Provincia::all();
        $Distritos = $entity != null && $entity->provincia_id != null ? Distrito::where('provincia_id', $entity->provincia_id)->get() : Distrito::all();
        $Grado = Grado_academico::all();

        return view('app.avisos._actualizar', [
            'Aviso' => $entity, 'Areas' => $Areas, 'Modalidades' => $Modalidades,
            'Condiciones' => $Condiciones, 'Horarios' => $Horarios, 'Provincias' => $Provincias, 'Distritos' => $Distritos, "Grado" => $Grado
        ]);
    }

    public function partialViewAvisoPostulantes($id)
    {
        $Aviso = Aviso::find($id);

        if ($Aviso != null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id)
            return view('app.avisos._postulantes', ['id' => $id]);

        return  null;
    }

    public function list_avisoPostulantes(Request $request)
    {
        return response()->json(['data' => AlumnoAviso::with('alumnos')->with('estados')->where('aviso_id', $request->id)->get()]);
    }

    /* Para Guardar o mejor dicho Republicar nuevo requerimiento*/
    /* Hecho por Sebastian */

    /* Listar Nuevamente */
    /* Hecho por Sebastian */
    public function partialView2($id)
    {
        $entity = null;

        if ($id != 0) $entity = Aviso::find($id);

        $Areas = Area::all();
        /* $Modalidades = Modalidad::all(); */
        /* $Condiciones = Condicion::all(); */
        /* $Horarios = Horario::all(); */
        /*  $Provincias = Provincia::all(); */
        $Distritos = $entity != null && $entity->provincia_id != null ? Distrito::where('provincia_id', $entity->provincia_id)->get() : Distrito::all();
        $Grado = Grado_academico::all();

        return view('app.avisos.actualizarw', [
            'Aviso' => $entity, 'Areas' => $Areas, /* 'Modalidades' => $Modalidades, */
            /* 'Condiciones' => $Condiciones, */ /* 'Horarios' => $Horarios, */ /* 'Provincias' => $Provincias, */ 'Distritos' => $Distritos, "Grado" => $Grado
        ]);
    }

    public function republicar(Request $request)
    {
        // Validación de los datos
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'distrito_id' => 'required|exists:distritos,id',
            'vacantes' => 'required|integer|min:1',
            'solicita_carrera' => 'required|string|max:255',
            'solicita_grado_a' => 'required|string|max:255',
            'periodo_vigencia' => 'required|date',
            /* 'ciclo_cursa' => 'required|string|max:10', */
            'descripcion' => 'required|string',
            'salario' => 'required|numeric|min:0',
        ]);

        // Verifica si la validación ha fallado
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Si la validación es exitosa, prepara los datos para la creación del aviso
        $data = [
            'empresa_id' => Auth::guard('empresasw')->user()->id,
            'titulo' => strtoupper($request->titulo),
            'link' => Str::slug($request->titulo),
            /* 'area_id' => 1, */ // Puedes ajustar según tu lógica de negocio
            'distrito_id' => $request->distrito_id,
            'vacantes' => $request->vacantes,
            'solicita_carrera' => $request->solicita_carrera,
            'solicita_grado_a' => $request->solicita_grado_a,
            'periodo_vigencia' => $request->periodo_vigencia,
            'ciclo_cursa' => $request->ciclo_cursa,
            'descripcion' => $request->descripcion,
            'salario' => $request->salario,
        ];

        // Intenta crear el aviso en la base de datos
        try {
            Aviso::create($data);
            // Si se crea correctamente, retorna una respuesta JSON con éxito
            return response()->json(['Success' => true, 'message' => 'Aviso creado correctamente'], 200);
        } catch (\Exception $e) {
            // Si ocurre un error, retorna una respuesta JSON con el error
            return response()->json(['Success' => false, 'error' => 'Error al crear el aviso: ' . $e->getMessage()], 500);
        }
    }

    //Feria empresa
    public function feriaEmpresa($id)
    {
        $feraExist = Feria::where('route', $id)->whereNull('deleted_at')->first();
        if ($feraExist) {
            $avisoEmpresaFeriaData = AvisoEmpresaFeria::where('id_feria', $feraExist->id)->where('ruc_empresa', Auth::guard('empresasw')->user()->ruc)->whereNull('deleted_at')->get();
            return view('app.avisos.feria.empresa.lista-feria-empresa')->with('feraExist', $feraExist)->with('avisoEmpresaFeriaData', $avisoEmpresaFeriaData);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function agregarFeriaEmpresa($id)
    {
        $feraExist = Feria::where('route', $id)->whereNull('deleted_at')->first();
        if ($feraExist) {
            return view('app.avisos.feria.empresa.agregar-feria-empresa')->with('feraExist', $feraExist);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function storeAgregarFeriaEmpresa(Request $request)
    {
        try {
            if ($request->description == null) {
                return redirect()->back()->withErrors(['description' => 'El campo descripción es obligatorio.']);
            }
            if ($request->requisitos == null) {
                return redirect()->back()->withErrors(['requisitos' => 'El campo requisitos es obligatorio.']);
            }
            $nombreOriginal = $request->name;
            $slug  = Str::slug(str_replace('ñ', 'n', $nombreOriginal));
            $slugExistente = AvisoEmpresaFeria::where('route', $slug)->exists();
            if ($slugExistente) {
                return redirect()->back()->withInput()->with('error', 'Ya existe una feria con este nombre o ruta. Por favor, elige otro nombre.');
            }
            DB::beginTransaction();
            $avisoEmpresaFeriaNew = new AvisoEmpresaFeria();
            $avisoEmpresaFeriaNew->id_feria = $request->idFeria;
            $avisoEmpresaFeriaNew->ruc_empresa = Auth::guard('empresasw')->user()->ruc;
            $avisoEmpresaFeriaNew->name = $request->name;
            $avisoEmpresaFeriaNew->description = $request->description;
            $avisoEmpresaFeriaNew->requisitos = $request->requisitos;
            $avisoEmpresaFeriaNew->url_zoom = $request->url_zoom;
            $avisoEmpresaFeriaNew->created_at = Carbon::now();
            $avisoEmpresaFeriaNew->save();
            $avisoEmpresaFeriaNew->route = $avisoEmpresaFeriaNew->ruc_empresa . '-' . $avisoEmpresaFeriaNew->id;
            $avisoEmpresaFeriaNew->updated_at = Carbon::now();
            $avisoEmpresaFeriaNew->save();
            DB::commit();
            return redirect()->route('empresa.feria-empresa', $request->idFeria)->with('success', "Se registró correctamente el aviso");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al guardar el aviso: ' . $e->getMessage());
        }
    }
    public function postulanteFeriaEmpresa($id)
    {
        $partes = explode('-', $id);
        if (count($partes) !== 2) {
            return redirect()->route('empresa.avisos');
        }
        $ruc = $partes[0];
        $idData = (int) $partes[1];
        $avisoEmpresaData = AvisoEmpresaFeria::where('id', $idData)->where('ruc_empresa', $ruc)->whereNull('deleted_at')->first();
        if ($avisoEmpresaData) {
            $feriaData = Feria::where('id', $avisoEmpresaData->id_feria)->whereNull('deleted_at')->first();
            if ($feriaData) {
                $postulacionesData = DB::table('postulacion_alumno_aviso_feria as p')
                    ->join('alumnos as a', 'p.dni_alumno', '=', 'a.dni')
                    ->where('p.state', 1)
                    ->where('p.id_feria', $avisoEmpresaData->id_feria)
                    ->where('p.id_aviso_feria', $avisoEmpresaData->id)
                    ->whereNull('p.deleted_at')
                    ->select('a.nombres as nameAlumno', 'a.apellidos as lastNameAlumno', 'a.email as emailAlumno', 'a.telefono as phoneAlumno', 'a.id as idAlumno')
                    ->get()->map(function ($item) {
                        $item->idAlumnoEncrypted = Crypt::encryptString($item->idAlumno);
                        return $item;
                    });
                if ($postulacionesData) {
                    return view('app.avisos.feria.empresa.lista-postulacion-aviso')->with('postulacionesData', $postulacionesData)->with('avisoEmpresaData', $avisoEmpresaData)->with('feriaData', $feriaData);
                } else {
                    return redirect()->route('empresa.avisos');
                }
            } else {
                return redirect()->route('empresa.avisos');
            }
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function postulanteFeriaCv($id)
    {
        try {
            $idAlumno = Crypt::decryptString($id);
            $Alumno = Alumno::where('id', $idAlumno)->first();
            $Areas = Area::all();
            $Provincias = Provincia::all();
            $distritoData  = Distrito::where('id', $Alumno->distrito_id)->first();
            $Educaciones = Educacion::where('alumno_id', $id)->orderBy('estudio_inicio', 'DESC')->get();
            $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $id)->orderBy('inicio_laburo', 'DESC')->get();
            $Educaciones = Educacion::where('alumno_id', $id)->orderBy('estudio_inicio', 'DESC')->get();
            $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_curso', 'DESC')->get();
            $pdf = PDF::loadView('app.avisos.cv_postulado',  ['referenciaLaboral' => $ReferenciaLaboral, 'provincias' => $Provincias, 'areas' => $Areas, 'alumno' => $Alumno, "experienciaLaboral" => $ExperienciaLaboral, "educaciones" => $Educaciones, 'distritoAlumno' => $distritoData->nombre]);
            return $pdf->stream();
        } catch (DecryptException $e) {
            return redirect()->route('empresa.avisos');
        }
    }
}
