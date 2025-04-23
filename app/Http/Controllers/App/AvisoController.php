<?php

namespace BolsaTrabajo\Http\Controllers\App;

use Carbon\Carbon;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Aviso;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Estado;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Horario;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\Modalidad;
use BolsaTrabajo\Provincia;
use Illuminate\Http\Request;
use BolsaTrabajo\AlumnoAviso;
use BolsaTrabajo\Grado_academico;
use Barryvdh\DomPDF\Facade as PDF;
use BolsaTrabajo\ReferenciaLaboral;
use BolsaTrabajo\ExperienciaLaboral;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use BolsaTrabajo\ProgramaEmpleabilidad;
use BolsaTrabajo\StudentApplicationFiles;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\ParticipantesEmpleabilidad;
use BolsaTrabajo\Http\Controllers\Controller;

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

        if (!Auth::guard('alumnos')->user() && $Postulante) {
            if ($Aviso != null && $Aviso->empresa_id == Auth::guard('empresasw')->user()->id) {
                $AlumnosAvisos = $AlumnosAvisos->get();
                return view('app.avisos.postulante_informacion', ['area' => $Area, 'educaciones' => $Educaciones, 'aviso' => $Aviso, 'alumnosAvisos' => $AlumnosAvisos, 'alumno' => $Alumno, 'postulante' => $Postulante, 'estados' => $Estados]);
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
        $participanteData = ParticipantesEmpleabilidad::whereIn('id_programa', $idsEmpleabilidad)
            ->where('dni', $userLogin->dni)
            ->whereNull('deleted_at')
            ->get()
            ->map(function ($item) {
                $item->id_encriptado = Crypt::encryptString($item->id_participante);
                return $item;
            });
        $studentApplicationData = StudentApplicationFiles::where('id_alumno', $userLogin->id)->whereNull('deleted_at')->first();
        return view('app.avisos.programa.index')
            ->with('participanteData', $participanteData)
            ->with('studentApplicationData', $studentApplicationData)
            ->with('nombrePrograma', $nombrePrograma)
            ->with('alumno', $userLogin);
    }
    public function certificado($id)
    {
        $idDesencriptado = Crypt::decryptString($id);
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
    public function uploadProgramRequirement(Request $request)
    {
        $alumnoId = $request->idAlumno;
        $studentApplicationData = StudentApplicationFiles::where('id_alumno', $request->idAlumno)->first();
        $data = [];
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $kb = $video->getSize() / 1024;
            if ($kb > 35840) {
                return back()->withErrors(['video' => 'El video no debe pesar más de 35 KB.']);
            }
            $folderPath = "app/students/{$alumnoId}/";
            $extension = $video->getClientOriginalExtension();
            $fileName = "presentacion-{$alumnoId}." . $extension;
            $video->move(public_path($folderPath), $fileName);
            $data['video_presentation'] = $fileName;
        }
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $kb = $pdf->getSize() / 1024;
            if ($kb > 35840) {
                return back()->withErrors(['video' => 'El pdf no debe pesar más de 35 KB.']);
            }
            $folderPath = "app/students/{$alumnoId}/";
            $extension = $pdf->getClientOriginalExtension();
            $fileName = "presentacion-{$alumnoId}." . $extension;
            $pdf->move(public_path($folderPath), $fileName);
            $data['cv_pdf'] = $fileName;
        }
        if ($studentApplicationData) {
            $data['updated_at'] = Carbon::now();
            $studentApplicationData->update($data);
        } else {
            $data['id_alumno'] = $alumnoId;
            $data['created_at'] = Carbon::now();
            $studentApplicationNew = new StudentApplicationFiles();
            $studentApplicationNew->fill($data);
            $studentApplicationNew->save();
        }
        return redirect()->back();
    }
}
