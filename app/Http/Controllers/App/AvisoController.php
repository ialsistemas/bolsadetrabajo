<?php

namespace BolsaTrabajo\Http\Controllers\App;

use Carbon\Carbon;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Feria;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Estado;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Horario;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\Modalidad;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\Fortalezas;
use Illuminate\Http\Request;
use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\Inteligencias;
use BolsaTrabajo\HistorialCitas;
use BolsaTrabajo\AsesorasExpress;
use BolsaTrabajo\Grado_academico;
use BolsaTrabajo\StrengthHistory;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use BolsaTrabajo\AvisoEmpresaFeria;
use BolsaTrabajo\ReferenciaLaboral;
use BolsaTrabajo\ExperienciaLaboral;
use Illuminate\Support\Facades\Auth;
use BolsaTrabajo\IntelligenceHistory;
use Illuminate\Support\Facades\Crypt;
use BolsaTrabajo\ProgramaEmpleabilidad;
use BolsaTrabajo\StudentApplicationFiles;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\ParticipantesEmpleabilidad;
use BolsaTrabajo\Http\Controllers\Controller;
use BolsaTrabajo\PostulacionAlumnoAvisoFeria;

class AvisoController extends Controller
{
    protected $avisos_per_page = 20;

    public function avisos(Request $request)
    {
        if ($request->ajax()) {

            $Perfil = Auth::guard('alumnos')->user() ? App::$PERFIL_ALUMNO : App::$PERFIL_EMPRESA;
            $Avisos = Aviso::orderBy('id', 'desc')
                ->whereHas('empresas', function ($q) {
                    $q->where('deleted_at', null);
                })
                ->where(function ($q) use ($request) {
                    if ($request->name) {
                        $q->where('titulo', 'like', '%' . $request->name . '%');
                    }
                })
                ->where(function ($q) use ($Perfil, $request) {
                    if (in_array($Perfil, [App::$PERFIL_EMPRESA])) {
                        $q->where('empresa_id', Auth::guard('empresasw')->user()->id);
                    }
                })
                ->where(function ($q) use ($request) {
                    if ($request->fecha_inicio) {
                        $q->whereDate('created_at', '>=', $request->fecha_inicio);
                    }
                })
                ->where(function ($q) use ($request) {
                    if ($request->fecha_final) {
                        $q->whereDate('created_at', '<=', $request->fecha_final);
                    }
                })
                /* ->where(function ($q) use ($request){ if($request->provincia_id){ $q->where('provincia_id', $request->provincia_id);}}) */
                ->where(function ($q) use ($request) {
                    if ($request->distrito_id) {
                        $q->where('distrito_id', $request->distrito_id);
                    }
                })
                ->where('estado_aviso', 1)
                ->where('solicita_grado_a', 'like', '%' . $request->tipo_estudiante . '%')
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
                'avisos' => view('app.avisos.ajax.listado')->with(['carrera' => $carrera, 'avisos' => $Avisos, 'i' => ($this->avisos_per_page * ($Avisos->currentPage() - 1) + 1)])->render(),
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

        //Feria
        $listaFeriaData = Feria::where('state', 1)->whereNull('deleted_at')->limit(1)->get();

        return view('app.avisos.index', [
            'areas' => $Areas,
            'provincias' => $Provincias,
            'horarios' => $Horarios,
            'modalidades' => $Modalidades,
            'anuncio' => $Anuncio,
            'grado_academico' => $Grado_academico,
            'alumno' => $Alumno,
            'listaFeriaData' => $listaFeriaData
        ]);
    }

    public function informacion($empresa, $slug)
    {
        /* $Aviso = Aviso::where('link', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('link',  $empresa);})->first(); */
        $Aviso = Aviso::where('id', $slug)
            ->whereHas('empresas', function ($q) use ($empresa) {
                $q->where('id',  $empresa);
            })->first();

        $AlumnosAvisos = AlumnoAviso::where('aviso_id', $Aviso->id)->get();

        if (!Auth::guard('alumnos')->check()) {
            if ($Aviso != null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id) {
                return view('app.avisos.informacion', ['aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos]);
            }
            return redirect(route('index'));
        }

        $AlumnosAviso = $AlumnosAvisos->where('alumno_id', Auth::guard('alumnos')->user()->id)->first();

        return view('app.avisos.informacion', ['aviso' => $Aviso, 'alumnoAviso' => $AlumnosAviso]);
    }

    public function postular(Request $request)
    {
        $status = false;
        $redirect = null;

        $errors = Alumno::ValidatePerfilAlumno();

        if (count($errors) > 0) {
            $redirect = route('alumno.perfil');
        } else {
            $Alumno = Auth::guard('alumnos')->user()->id;
            $AlumnoAvisos = AlumnoAviso::where('alumno_id', $Alumno)->where('aviso_id', $request->aviso_id)->first();
            if (!$AlumnoAvisos) {
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
            ->whereHas('empresas', function ($q) use ($empresa) {
                $q->where('id',  $empresa);
            })->first();

        $AlumnosAvisos = AlumnoAviso::with('alumnos')->where('aviso_id', $Aviso->id)->get();

        if (!Auth::guard('alumnos')->user()) {
            if ($Aviso != null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id) {

                return view('app.avisos.postulantes', [
                    'aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos, 'postulantes' => $AlumnosAvisos,
                    "Educacion" => $Educacion, "area" => $Area, "Distrito" => $Distrito, "Grado_academico" => $Grado_academico
                ]);
            }
        }
        return redirect(route('index'));
    }

    public function postulante_informacion($empresa, $slug, $alumno)
    {
        /* $Aviso = Aviso::where('link', $slug)
            ->whereHas('empresas', function ($q) use ($empresa){ $q->where('link',  $empresa);})->first(); */
        $Aviso = Aviso::where('id', $slug)->whereHas('empresas', function ($q) use ($empresa) {
            $q->where('id',  $empresa);
        })->first();
        $Alumno = Alumno::where('usuario_alumno', $alumno)->first();
        $updateEstado = AlumnoAviso::where('alumno_id', $Alumno->id)->where('aviso_id', $slug)->update(['estado_id' => 2]);
        $Estados = Estado::whereIn('id', [2, 4, 5])->get();
        $AlumnosAvisos = AlumnoAviso::with('alumnos')->where('aviso_id', $Aviso->id);
        $Postulante = $AlumnosAvisos->where('alumno_id', $Alumno->id)->first();
        $Educaciones = Educacion::where('alumno_id', $Alumno->id)->get();
        $Area = Area::all();
        $inteligenciasHistorialData = IntelligenceHistory::where('id_alumno', $Alumno->id)->whereNull('deleted_at')->first();
        $fortalezasHistorialData = StrengthHistory::where('id_alumno', $Alumno->id)->whereNull('deleted_at')->first();
        if (!Auth::guard('alumnos')->user() && $Postulante) {
            if ($Aviso != null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id) {
                $AlumnosAvisos = $AlumnosAvisos->get();
                return view('app.avisos.postulante_informacion', ['area' => $Area, 'educaciones' => $Educaciones, 'aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos, 'alumno' => $Alumno, 'postulante' => $Postulante, 'estados' => $Estados, 'inteligenciasHistorialData' => $inteligenciasHistorialData, 'fortalezasHistorialData' => $fortalezasHistorialData]);
            }
        }
        return redirect(route('index'));
    }

    // function hecho por marco
    public function donwloadCValumno($empresa, $slug, $alumno)
    {

        $Alumno = Alumno::where('id', $alumno)->first();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('id', $Alumno->distrito_id)->get();
        $Educaciones = Educacion::where('alumno_id', $alumno)->orderBy('estudio_inicio', 'DESC')->get();
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $alumno)->orderBy('inicio_laburo', 'DESC')->get();
        $Educaciones = Educacion::where('alumno_id', $alumno)->orderBy('estudio_inicio', 'DESC')->get();

        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_curso', 'DESC')->get();

        $pdf = PDF::loadView('app.avisos.cv_postulado',  ['referenciaLaboral' => $ReferenciaLaboral, 'provincias' => $Provincias, 'areas' => $Areas, 'alumno' => $Alumno, "experienciaLaboral" => $ExperienciaLaboral, "educaciones" => $Educaciones, 'distritos' => $Distritos]);
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

        return response()->json([
            'Success' => true, 'postulados' => $Postulados, 'evaluados' => $Evaluados,
            'seleccionados' => $Seleccionados, 'aceptados' => $Aceptados, 'descartados' => $Descartados
        ]);
    }

    public function empresa_informacion($slug)
    {
        return view('app.empresas.informacion', ['Empresa' => Empresa::where('link', $slug)->first()]);
    }

    public function delete(Request $request)
    {

        $status = false;
        $message = null;

        $entity = Aviso::find($request->id);

        if ($entity->empresa_id == Auth::guard('empresasw')->user()->id)
            if ($entity->delete()) $status = true;
            else
                $message = "No tiene permisos para realizar esta acción";

        return response()->json(['Success' => $status, 'Message' => $message]);
    }


    public function progresoCV(Request $request)
    {
        $alumnoId = $request->input('alumnoId');

        if (!$alumnoId) {
            return response()->json(['error' => 'ID del alumno no proporcionado'], 400);
        }

        $alumno = Alumno::find($alumnoId);

        if (!$alumno) {
            return response()->json(['error' => 'Alumno no encontrado'], 404);
        }

        // Inicia el contador de campos completados
        $completados = 0;

        // Contar los campos en la tabla 'alumnos'
        if (
            $alumno->nombres && $alumno->apellidos && $alumno->dni && $alumno->telefono &&
            $alumno->email && $alumno->fecha_nacimiento && $alumno->direccion && $alumno->foto
        ) {
            $completados += 8;
        } else {
            if ($alumno->nombres) $completados++;
            if ($alumno->apellidos) $completados++;
            if ($alumno->dni) $completados++;
            if ($alumno->telefono) $completados++;
            if ($alumno->email) $completados++;
            if ($alumno->fecha_nacimiento) $completados++;
            if ($alumno->direccion) $completados++;
            if ($alumno->foto) $completados++;
            if ($alumno->foto) $completados++;
        }

        // Contar los registros en la tabla 'referencia_laborals'
        $referenciasLaborales = ReferenciaLaboral::where('alumno_id', $alumnoId)->count();
        if ($referenciasLaborales > 0) {
            $completados++;
        }
        // Contar los registros en la tabla 'experiencia_laborals'
        $experienciasLaborales = ExperienciaLaboral::where('alumno_id', $alumnoId)->count();
        if ($experienciasLaborales > 0) {
            $completados++;
        }
        // Contar los registros en la tabla 'educacions'
        $educacion = Educacion::where('alumno_id', $alumnoId)->count();
        if ($educacion > 0) {
            $completados++;
        }
        // Total de campos a verificar
        $totalCampos = 8 /*+ 1*/ + 1 + 1 + 1; // 8 campos de alumnos, 1 de perfil, 1 de referencias, 1 de experiencia y 1 de educación
        // Calcular el progreso en porcentaje
        $progreso = ($completados / $totalCampos) * 100;

        return response()->json(['progreso' => (int)$progreso]);
    }

    public function capacitaciones($id)
    {
        $userLogin = Auth::guard('alumnos')->user();
        $nombrePrograma = strtoupper(str_replace('-', ' ', $id));
        $empleabilidadData = ProgramaEmpleabilidad::whereRaw('UPPER(tipo_programa) = ?', [$nombrePrograma])
            ->whereNull('deleted_at')
            ->get();
        if ($empleabilidadData->isEmpty()) {
            return redirect()->route('alumno.avisos');
        }
        $idsEmpleabilidad = $empleabilidadData->pluck('id')->toArray();
        $participanteAprobadoData = ParticipantesEmpleabilidad::whereIn('id_programa', $idsEmpleabilidad)
            ->where('dni', $userLogin->dni)
            ->where('certified_status', 1)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                $item->id_encriptado = Crypt::encryptString($item->id_participante);
                return $item;
            });
        $participanteDesaprobadoData = ParticipantesEmpleabilidad::whereIn('id_programa', $idsEmpleabilidad)
            ->where('dni', $userLogin->dni)
            ->where('certified_status', 0)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                $item->id_encriptado = Crypt::encryptString($item->id_participante);
                return $item;
            });
        return view('app.avisos.programa.index')
            ->with('participanteAprobadoData', $participanteAprobadoData)
            ->with('participanteDesaprobadoData', $participanteDesaprobadoData)
            ->with('nombrePrograma', $nombrePrograma)
            ->with('alumno', $userLogin);
    }
    public function certificado($id)
    {
        try {
            $idDesencriptado = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('alumno.avisos')->with('error', 'Hubo un problema al generar el certificado.');
        }
        Carbon::setLocale('es');
        $entity = ParticipantesEmpleabilidad::find($idDesencriptado);
        $programas = [
            "DESPEGA 360" => [
                "template" => "app/img/template/template-despega-360.jpg",
                "font-size" => "31px",
                "id" => 1
            ],
            "SKILLS TO WORK" => [
                "template" => "app/img/template/template-skills-to-work.jpg",
                "font-size" => "31px",
                "id" => 2
            ],
            "CARRERA PRO" => [
                "template" => "app/img/template/template-carrra-pro.jpg",
                "font-size" => "31px",
                "id" => 3
            ]
        ];
        $idPrograma = $entity->id_programa;
        $programasEmpleabilidadesData = ProgramaEmpleabilidad::where('id', $idPrograma)->first();
        $namePrograma = $programasEmpleabilidadesData->tipo_programa;
        $templatePdf = $programas[$namePrograma];
        $date = Carbon::parse($programasEmpleabilidadesData->registro)->translatedFormat('d \d\e F \d\e\l Y');
        $pdf = PDF::loadView('auth.programa.certificados_alumnos.pdf_certificado', [
            'templatePdf' => $templatePdf,
            'entity' => $entity,
            'date' => $date
        ])->setPaper('A4', 'landscape');
        return $pdf->stream('certificado-' . ($entity->nombres . '-' . $entity->apellidos) . '.pdf');
    }
    public function pendiente($id)
    {
        try {
            $idDesencriptado = Crypt::decryptString($id);
        } catch (\Exception $e) {
            return redirect()->route('alumno.avisos')->with('error', 'Hubo un problema al generar el formulario.');
        }
        $userLogin = Auth::guard('alumnos')->user();
        $entity = ParticipantesEmpleabilidad::find($idDesencriptado);
        $programasEmpleabilidadesData = ProgramaEmpleabilidad::where('id', $entity->id_programa)->first();
        $studentApplicationFilesData = StudentApplicationFiles::where('dni_alumno', $entity->dni)->where('id_programa', $entity->id_programa)->first();
        return view('app.avisos.programa.upload_file')->with('programasEmpleabilidadesData', $programasEmpleabilidadesData)->with('studentApplicationFilesData', $studentApplicationFilesData)->with('alumno', $userLogin);
    }
    public function uploadProgramRequirement(Request $request)
    {
        $alumnoId = $request->idAlumno;
        $uploadId = $request->idUpload;
        $userData = Alumno::where('id', $alumnoId)->first();
        $studentApplicationData = StudentApplicationFiles::where('id', $uploadId)->first();
        $data = [];
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $kb = $pdf->getSize() / 1024;
            if ($kb > 35840) {
                return back()->withErrors(['video' => 'El pdf no debe pesar más de 35 KB.']);
            }
            $folderPath = "app/students/{$userData->dni}/";
            $extension = $pdf->getClientOriginalExtension();
            $fileName = "presentacion-{$uploadId}." . $extension;
            $pdf->move(public_path($folderPath), $fileName);
            $data['cv_pdf'] = $fileName;
        }
        $data['updated_at'] = Carbon::now();
        $studentApplicationData->update($data);
        return redirect()->back();
    }
    //test
    public function testInteligenciasMultiples()
    {
        $userLogin = Auth::guard('alumnos')->user();
        $intelligenceHistoryData = IntelligenceHistory::where('id_alumno', $userLogin->id)->orderByDesc('updated_at')->first();
        if ($intelligenceHistoryData) {
            $fechaUltimaActualizacion = Carbon::parse($intelligenceHistoryData->updated_at);
            if (now()->diffInMonths($fechaUltimaActualizacion) < 6) {
                return redirect()->route('alumno.resultado-inteligencias-multiples');
            }
        }
        return view('app.home.quiz.encuesta-inteligencias');
    }
    public function storeTestInteligenciasMultiples(Request $request)
    {
        $userLogin = Auth::guard('alumnos')->user();
        $preguntas = $request->only([
            'preguntaUna', 'preguntaDos', 'preguntaTres', 'preguntaCuatro', 'preguntaCinco',
            'preguntaSeis', 'preguntaSiete', 'preguntaOcho', 'preguntaNueve', 'preguntaDiez',
            'preguntaOnce', 'preguntaDoce', 'preguntaTrece', 'preguntaCatorce', 'preguntaQuince',
            'preguntaDieciseis', 'preguntaDiecisiete', 'preguntaDieciocho', 'preguntaDiecinueve', 'preguntaVeinte',
            'preguntaVeintiuno', 'preguntaVeintidos', 'preguntaVeintitres', 'preguntaVeinticuatro', 'preguntaVeinticinco',
            'preguntaVeintiseis', 'preguntaVeintisiete', 'preguntaVeintiocho', 'preguntaVeintinueve', 'preguntaTreinta',
            'preguntaTreintaiuno', 'preguntaTreintaidos', 'preguntaTreintaitres', 'preguntaTreintaicuatro', 'preguntaTreintaicinco'
        ]);
        if (count($preguntas) < 35) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error_general' => 'Debe responder todas las preguntas antes de enviar la encuesta.']);
        }
        $historialExistente = IntelligenceHistory::where('id_alumno', $userLogin->id)
            ->orderByDesc('updated_at')
            ->first();
        if ($historialExistente) {
            $fechaUltimaActualizacion = Carbon::parse($historialExistente->updated_at);
            if (now()->diffInMonths($fechaUltimaActualizacion) < 6) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error_general' => 'Usted ya resolvió esta prueba. Debe esperar 6 meses para actualizarla.']);
            }
        }
        $mapa = [
            1 => ['preguntaNueve', 'preguntaDiez', 'preguntaDiecisiete', 'preguntaVeintidos', 'preguntaTreinta'],
            2 => ['preguntaCinco', 'preguntaSiete', 'preguntaQuince', 'preguntaVeinte', 'preguntaVeinticinco'],
            3 => ['preguntaUna', 'preguntaOnce', 'preguntaCatorce', 'preguntaVeintitres', 'preguntaVeintisiete'],
            4 => ['preguntaOcho', 'preguntaDieciseis', 'preguntaDiecinueve', 'preguntaVeintiuno', 'preguntaVeintinueve'],
            5 => ['preguntaTres', 'preguntaCuatro', 'preguntaTrece', 'preguntaVeinticuatro', 'preguntaVeintiocho'],
            6 => ['preguntaDos', 'preguntaSeis', 'preguntaVeintiseis', 'preguntaTreintaiuno', 'preguntaTreintaitres'],
            7 => ['preguntaDoce', 'preguntaDieciocho', 'preguntaTreintaidos', 'preguntaTreintaicuatro', 'preguntaTreintaicinco'],
        ];
        $inteligenciasData = Inteligencias::whereNull('deleted_at')->get()->keyBy('id');
        $destacadas = [];
        foreach ($mapa as $id => $keys) {
            $puntaje = array_sum(array_map(function ($k) use ($preguntas) {
                return (int) ($preguntas[$k] ?? 0);
            }, $keys));
            if ($puntaje >= 4 && $puntaje <= 5 && $inteligenciasData->has($id)) {
                $inteligencia = $inteligenciasData[$id];
                $destacadas[] = [
                    'name' => $inteligencia->name,
                    'description' => $inteligencia->descripcion_simple,
                    'puntaje' => $puntaje
                ];
            }
        }
        try {
            DB::beginTransaction();
            if ($historialExistente) {
                $historialExistente->historial_preguntas = json_encode($preguntas);
                $historialExistente->estados_inteligencia = json_encode($destacadas);
                $historialExistente->updated_at = now();
                $historialExistente->save();
            } else {
                $nuevo = new IntelligenceHistory();
                $nuevo->id_alumno = $userLogin->id;
                $nuevo->historial_preguntas = json_encode($preguntas);
                $nuevo->estados_inteligencia = json_encode($destacadas);
                $nuevo->created_at = now();
                $nuevo->updated_at = now();
                $nuevo->save();
            }
            DB::commit();
            return redirect()->route('alumno.resultado-inteligencias-multiples');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error_general' => 'Ocurrió un error al guardar los datos: ' . $e->getMessage()
                ]);
        }
    }
    public function resultadoInteligenciasMultiples()
    {
        $userLogin = Auth::guard('alumnos')->user();
        $intelligenceHistoryData = IntelligenceHistory::where('id_alumno', $userLogin->id)->first();
        if (!$intelligenceHistoryData) {
            return redirect()->route('alumno.test-inteligencias-multiples');
        }
        $destacadas = [];
        if ($intelligenceHistoryData && $intelligenceHistoryData->estados_inteligencia) {
            $decoded = json_decode($intelligenceHistoryData->estados_inteligencia, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $destacadas = $decoded;
            }
        }
        $fechaReferencia = Carbon::parse($intelligenceHistoryData->updated_at);
        $puedeMostrarBoton = Carbon::now()->greaterThanOrEqualTo($fechaReferencia->addMonths(6));
        return view('app.home.quiz.respuesta-encuesta-inteligencias')->with('destacadas', $destacadas)->with('fechaReferencia', $fechaReferencia)->with('puedeMostrarBoton', $puedeMostrarBoton)->with('intelligenceHistoryData', $intelligenceHistoryData);
    }
    public function storeActiveInteligenciasMultiples(Request $request)
    {
        $userLogin = Auth::guard('alumnos')->user();
        $activo = $request->has('active') ? 1 : 0;

        $actualizado = IntelligenceHistory::where('id_alumno', $userLogin->id)->update([
            'visualizacion' => $activo,
            'updated_at' => now()
        ]);

        return redirect()->back();
    }
    public function testFortalezasPersonales()
    {
        $userLogin = Auth::guard('alumnos')->user();
        $strengthHistoryData = StrengthHistory::where('id_alumno', $userLogin->id)->orderByDesc('updated_at')->first();
        if ($strengthHistoryData) {
            $fechaUltimaActualizacion = Carbon::parse($strengthHistoryData->updated_at);
            if (now()->diffInMonths($fechaUltimaActualizacion) < 6) {
                return redirect()->route('alumno.resultado-fortalezas-personales');
            }
        }
        return view('app.home.quiz.encuesta-fortaleza');
    }
    public function storeTestFortalezasPersonales(Request $request)
    {
        $userLogin = Auth::guard('alumnos')->user();
        $preguntas = $request->only([
            'preguntaUno', 'preguntaDos', 'preguntaTres', 'preguntaCuatro', 'preguntaCinco',
            'preguntaSeis', 'preguntaSiete', 'preguntaOcho', 'preguntaNueve', 'preguntaDiez',
            'preguntaOnce', 'preguntaDoce', 'preguntaTrece', 'preguntaCatorce', 'preguntaQuince',
            'preguntaDieciseis', 'preguntaDiecisiete', 'preguntaDieciocho', 'preguntaDiecinueve', 'preguntaVeinte',
            'preguntaVeintiuno', 'preguntaVeintidos', 'preguntaVeintitres', 'preguntaVeinticuatro', 'preguntaVeinticinco',
            'preguntaVeintiseis', 'preguntaVeintisiete', 'preguntaVeintiocho', 'preguntaVeintinueve', 'preguntaTreinta',
            'preguntaTreintiuno', 'preguntaTreintidos', 'preguntaTreintitres', 'preguntaTreinticuatro', 'preguntaTreinticinco'
        ]);
        if (count($preguntas) < 35) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['error_general' => 'Debe responder todas las preguntas antes de enviar la encuesta.']);
        }
        $historialExistente = strengthHistory::where('id_alumno', $userLogin->id)
            ->orderByDesc('updated_at')
            ->first();
        if ($historialExistente) {
            $fechaUltimaActualizacion = Carbon::parse($historialExistente->updated_at);
            if (now()->diffInMonths($fechaUltimaActualizacion) < 6) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['error_general' => 'Usted ya resolvió esta prueba. Debe esperar 6 meses para actualizarla.']);
            }
        }
        $mapa = [
            1 => ['preguntaDos', 'preguntaCinco', 'preguntaVeintitres', 'preguntaVeintinueve', 'preguntaTreintitres', 'preguntaTreinticinco'],
            2 => ['preguntaSiete', 'preguntaDiez', 'preguntaDoce', 'preguntaDiecinueve', 'preguntaVeintidos', 'preguntaVeinticinco', 'preguntaTreintidos'],
            3 => ['preguntaTres', 'preguntaOcho', 'preguntaTrece', 'preguntaDieciocho', 'preguntaVeintisiete', 'preguntaTreinta'],
            4 => ['preguntaUno', 'preguntaSeis', 'preguntaNueve', 'preguntaOnce', 'preguntaCatorce', 'preguntaDieciseis', 'preguntaVeinte', 'preguntaVeinticuatro', 'preguntaVeintiseis', 'preguntaVeintiocho', 'preguntaTreintiuno'],
            5 => ['preguntaCuatro', 'preguntaQuince', 'preguntaDiecisiete', 'preguntaVeintiuno', 'preguntaTreinticuatro'],
        ];
        $fortalizasData = Fortalezas::whereNull('deleted_at')->get()->keyBy('id');
        $estados = DB::table('estado_fortaleza')->get()->groupBy('id_fortaleza');
        $puntajesData = [];
        foreach ($mapa as $id => $keys) {
            $puntaje = array_sum(array_map(function ($k) use ($preguntas) {
                return (int) ($preguntas[$k] ?? 0);
            }, $keys));
            if ($fortalizasData->has($id)) {
                $inteligencia = $fortalizasData[$id];
                $total = $inteligencia->total > 0 ? $inteligencia->total : 1;
                $porcentaje = round(($puntaje / $total) * 100, 2);
                $estadoNombre = '';
                $estadoDescripcion = '';
                if ($estados->has($id)) {
                    $rangos = $estados[$id];
                    foreach ($rangos as $estado) {
                        if ($porcentaje <= 33.33 && strtolower($estado->name) == 'bajo') {
                            $estadoNombre = $estado->name;
                            $estadoDescripcion = $estado->description;
                            break;
                        } elseif ($porcentaje > 33.33 && $porcentaje <= 66.66 && strtolower($estado->name) == 'medio') {
                            $estadoNombre = $estado->name;
                            $estadoDescripcion = $estado->description;
                            break;
                        } elseif ($porcentaje > 66.66 && strtolower($estado->name) == 'alto') {
                            $estadoNombre = $estado->name;
                            $estadoDescripcion = $estado->description;
                            break;
                        }
                    }
                }
                $puntajesData[] = [
                    'name' => $inteligencia->name,
                    'description' => $inteligencia->descripcion_simple,
                    'puntaje' => $puntaje,
                    'total' => $total,
                    'porcentaje' => $porcentaje,
                    'estado' => $estadoNombre,
                    'estado_description' => $estadoDescripcion
                ];
            }
        }
        try {
            DB::beginTransaction();
            if ($historialExistente) {
                $historialExistente->historial_preguntas = json_encode($preguntas);
                $historialExistente->estados_fortaleza = json_encode($puntajesData);
                $historialExistente->updated_at = now();
                $historialExistente->save();
            } else {
                $nuevo = new strengthHistory();
                $nuevo->id_alumno = $userLogin->id;
                $nuevo->historial_preguntas = json_encode($preguntas);
                $nuevo->estados_fortaleza = json_encode($puntajesData);
                $nuevo->created_at = now();
                $nuevo->updated_at = now();
                $nuevo->save();
            }
            DB::commit();
            return redirect()->route('alumno.resultado-fortalezas-personales');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'error_general' => 'Ocurrió un error al guardar los datos: ' . $e->getMessage()
                ]);
        }
    }
    public function resultadoFortalezasPersonales()
    {
        $userLogin = Auth::guard('alumnos')->user();
        $strengthHistoryData = StrengthHistory::where('id_alumno', $userLogin->id)->first();
        if (!$strengthHistoryData) {
            return redirect()->route('alumno.test-fortalezas-personales');
        }
        $porcentajeData = [];
        if ($strengthHistoryData && $strengthHistoryData->estados_fortaleza) {
            $decoded = json_decode($strengthHistoryData->estados_fortaleza, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $porcentajeData = $decoded;
            }
        }
        $fechaReferencia = Carbon::parse($strengthHistoryData->updated_at);
        $puedeMostrarBoton = Carbon::now()->greaterThanOrEqualTo($fechaReferencia->addMonths(6));
        return view('app.home.quiz.respuesta-encuesta-fortaleza')->with('destacadas', $porcentajeData)->with('fechaReferencia', $fechaReferencia)->with('puedeMostrarBoton', $puedeMostrarBoton)->with('strengthHistoryData', $strengthHistoryData);
    }
    public function storeActiveFortalezasPersonales(Request $request)
    {
        $userLogin = Auth::guard('alumnos')->user();
        $activo = $request->has('active') ? 1 : 0;

        $actualizado = StrengthHistory::where('id_alumno', $userLogin->id)->update([
            'visualizacion' => $activo,
            'updated_at' => now()
        ]);

        return redirect()->back();
    }
    //Feria
    public function feriaEmpresaAlumno($id)
    {
        $Alumno = Auth::guard('alumnos')->user();
        //Feria
        $feraExist = Feria::where('route', $id)->whereNull('deleted_at')->first();
        if ($feraExist) {
            $avisoEmpresaData = DB::table('aviso_empresa_feria')
                ->join('empresas', 'aviso_empresa_feria.ruc_empresa', '=', 'empresas.ruc')
                ->where('aviso_empresa_feria.id_feria', $feraExist->id)
                ->whereNull('aviso_empresa_feria.deleted_at')
                ->select(
                    'aviso_empresa_feria.ruc_empresa',
                    DB::raw('MAX(empresas.link) as linkEmpresa'),
                    DB::raw('MAX(empresas.name_comercio) as nameEmpresa'),
                    DB::raw('MAX(empresas.logo) as logoEmpresa'),
                )
                ->groupBy('aviso_empresa_feria.ruc_empresa')
                ->get();
            return view('app.avisos.feria.alumno.lista-feria-empresa-alumno')->with('feraExist', $feraExist)->with('avisoEmpresaData', $avisoEmpresaData)->with('alumno', $Alumno);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function asesoriasExpressAlumno($id)
    {
        $Alumno = Auth::guard('alumnos')->user();
        $feraExist = Feria::where('route', $id)->whereNull('deleted_at')->first();
        if ($feraExist) {
            $asesoraData = AsesorasExpress::whereNull('deleted_at')->get();
            if ($asesoraData) {
                return view('app.avisos.feria.alumno.asesorias-express.index')->with('alumno', $Alumno)->with('feraExist', $feraExist)->with('asesoraData', $asesoraData);
            } else {
                return redirect()->route('empresa.avisos');
            }
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function detalleAsesoraExpress($id)
    {
        $Alumno = Auth::guard('alumnos')->user();
        $asesoraData = AsesorasExpress::where('route', $id)->first();
        if ($asesoraData) {
            return view('app.avisos.feria.alumno.asesorias-express.detalle')->with('asesoraData', $asesoraData)->with('alumno', $Alumno);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function alumnoSacarCita(Request $request)
    {
        $dia = $request->input('fecha');
        $horasOcupadas = HistorialCitas::where('dia', $dia)->where('state', 1)->whereNull('deleted_at')->pluck('hora')->map(function ($hora) {
            return Carbon::parse($hora)->format('H:i');
        });
        return response()->json([
            'horas_ocupadas' => $horasOcupadas
        ]);
    }
    public function storeAlumnoSacarCita(Request $request)
    {
        try {
            DB::beginTransaction();
            $alumnoData = Auth::guard('alumnos')->user();
            $now = Carbon::now();
            $citaRegistrada = HistorialCitas::where('dni', $alumnoData->dni)->where('state', 1)->whereNull('deleted_at')->whereDate('created_at', $now->toDateString())->first();
            if ($citaRegistrada) {
                return response()->json([
                    'message' => 'Usted ya se registró. Solo puede agendar una cita por día.'
                ], 400);
            }
            $citaNew = new HistorialCitas();
            $citaNew->id_asesora = $request->idAsesora;
            $citaNew->dni = $request->cod_alumno;
            $citaNew->motivo = $request->motivo;
            $citaNew->dia = $request->fecha;
            $citaNew->hora = $request->hora;
            $citaNew->state = 1;
            $citaNew->phone = $request->phone;
            $citaNew->dni = $alumnoData->dni;
            $citaNew->created_at = Carbon::now();
            $citaNew->save();
            DB::commit();
            return response()->json([
                'message' => 'Cita registrada exitosamente.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Ocurrió un error al registrar la cita.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function ecenarioAvisoAlumnoEmpresa($id)
    {
        $Alumno = Auth::guard('alumnos')->user();
        $empresaExist = Empresa::where('link', $id)->whereNull('deleted_at')->first();
        if ($empresaExist) {
            $avisoAlumnoFeriaData = DB::table('aviso_empresa_feria')
                ->join('empresas', 'aviso_empresa_feria.ruc_empresa', '=', 'empresas.ruc')
                ->where('aviso_empresa_feria.ruc_empresa', $empresaExist->ruc)
                ->whereNull('aviso_empresa_feria.deleted_at')
                ->select(
                    'aviso_empresa_feria.id as idAvisoEmpresaFeria',
                    'aviso_empresa_feria.name as nameAvisoEmpresaFeria',
                    'aviso_empresa_feria.description as descriptionAvisoEmpresaFeria',
                    'aviso_empresa_feria.requisitos as requisitosAvisoEmpresaFeria',
                    'aviso_empresa_feria.url_zoom as urlZoomAvisoEmpresaFeria',
                    'aviso_empresa_feria.created_at as createdAtAvisoEmpresaFeria',
                    'empresas.razon_social as razonSocialEmpresa',
                    'empresas.direccion as direccionEmpresa',
                    DB::raw('TIMESTAMPDIFF(HOUR, aviso_empresa_feria.created_at, NOW()) as horasTranscurridas'),
                )
                ->get();
            return view('app.avisos.feria.alumno.ecenario-feria-alumno')->with('empresaExist', $empresaExist)->with('avisoAlumnoFeriaData', $avisoAlumnoFeriaData)->with('alumno', $Alumno);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function feriaAvisoAlumnoEmpresa($id)
    {
        $Alumno = Auth::guard('alumnos')->user();
        //Feria
        $empresaExist = Empresa::where('link', $id)->whereNull('deleted_at')->first();
        if ($empresaExist) {
            $avisoAlumnoFeriaData = DB::table('aviso_empresa_feria')
                ->join('empresas', 'aviso_empresa_feria.ruc_empresa', '=', 'empresas.ruc')
                ->where('aviso_empresa_feria.ruc_empresa', $empresaExist->ruc)
                ->whereNull('aviso_empresa_feria.deleted_at')
                ->select(
                    'aviso_empresa_feria.id as idAvisoEmpresaFeria',
                    'aviso_empresa_feria.name as nameAvisoEmpresaFeria',
                    'aviso_empresa_feria.description as descriptionAvisoEmpresaFeria',
                    'aviso_empresa_feria.requisitos as requisitosAvisoEmpresaFeria',
                    'empresas.logo as imgLogoAvisoEmpresaFeria',
                    'aviso_empresa_feria.created_at as createdAtAvisoEmpresaFeria',
                    'empresas.razon_social as razonSocialEmpresa',
                    'empresas.direccion as direccionEmpresa',
                    DB::raw('TIMESTAMPDIFF(HOUR, aviso_empresa_feria.created_at, NOW()) as horasTranscurridas'),
                )
                ->get();
            return view('app.avisos.feria.alumno.lista-feria-alumno')->with('empresaExist', $empresaExist)->with('avisoAlumnoFeriaData', $avisoAlumnoFeriaData)->with('alumno', $Alumno);
        } else {
            return redirect()->route('empresa.avisos');
        }
    }
    public function detalleFeriaAviso(Request $request)
    {
        $dniAlumno = Auth::guard('alumnos')->user()->dni;
        $aviso = DB::table('aviso_empresa_feria')
            ->join('empresas', 'aviso_empresa_feria.ruc_empresa', '=', 'empresas.ruc')
            ->leftJoin('postulacion_alumno_aviso_feria', function ($join) use ($dniAlumno) {
                $join->on('aviso_empresa_feria.id', '=', 'postulacion_alumno_aviso_feria.id_aviso_feria')
                    ->where('postulacion_alumno_aviso_feria.dni_alumno', '=', $dniAlumno)
                    ->whereNull('postulacion_alumno_aviso_feria.deleted_at');
            })
            ->where('aviso_empresa_feria.id', $request->id)
            ->whereNull('aviso_empresa_feria.deleted_at')
            ->select(
                'aviso_empresa_feria.id as idAvisoEmpresaFeria',
                'aviso_empresa_feria.name as nameAvisoEmpresaFeria',
                'aviso_empresa_feria.description as descriptionAvisoEmpresaFeria',
                'aviso_empresa_feria.requisitos as requisitosAvisoEmpresaFeria',
                'empresas.logo as imgLogoAvisoEmpresaFeria',
                'aviso_empresa_feria.created_at as createdAtAvisoEmpresaFeria',
                'empresas.razon_social as razonSocialEmpresa',
                'empresas.direccion as direccionEmpresa',
                DB::raw('TIMESTAMPDIFF(HOUR, aviso_empresa_feria.created_at, NOW()) as horasTranscurridas'),
                DB::raw('COALESCE(postulacion_alumno_aviso_feria.state, 0) as estado')
            )
            ->first();
        return response()->json($aviso);
    }
    public function postularme(Request $request)
    {
        $dniAlumno = Auth::guard('alumnos')->user()->dni;
        $idAviso = $request->id;
        $avisoData = AvisoEmpresaFeria::where('id', $idAviso)
            ->whereNull('deleted_at')
            ->first();
        if (!$avisoData) {
            return response()->json(['status' => "error", "message" => "El aviso no existe."], 404);
        }
        $postulacionExistente = PostulacionAlumnoAvisoFeria::where('id_feria', $avisoData->id_feria)
            ->where('id_aviso_feria', $avisoData->id)
            ->where('dni_alumno', $dniAlumno)
            ->whereNull('deleted_at')
            ->first();
        if ($postulacionExistente) {
            $nuevoEstado = $postulacionExistente->state == 1 ? 0 : 1;
            $postulacionExistente->update([
                'state' => $nuevoEstado,
                'updated_at' => Carbon::now()
            ]);
            return response()->json([
                'status' => "success",
                'message' => $nuevoEstado == 1 ? "Te has postulado." : "Has desistido de la postulación.",
                'nuevo_estado' => $nuevoEstado
            ]);
        }
        $postulacionNueva = new PostulacionAlumnoAvisoFeria();
        $postulacionNueva->id_feria = $avisoData->id_feria;
        $postulacionNueva->id_aviso_feria = $avisoData->id;
        $postulacionNueva->dni_alumno = $dniAlumno;
        $postulacionNueva->state = 1;
        $postulacionNueva->created_at = Carbon::now();
        $postulacionNueva->save();
        return response()->json([
            'status' => "success",
            'message' => "Te has postulado correctamente.",
            'nuevo_estado' => 1
        ]);
    }
}
