<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use Carbon\Carbon;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Programa;
use BolsaTrabajo\Condicion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use BolsaTrabajo\Participantes;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use BolsaTrabajo\ProgramaEmpleabilidad;
use BolsaTrabajo\StudentApplicationFiles;
use Illuminate\Support\Facades\Validator;
use BolsaTrabajo\ParticipantesEmpleabilidad;
use BolsaTrabajo\Http\Controllers\Controller;

class ProgramaController extends Controller
{
    public function index()
    {
        return view('auth.programa.index');
    }

    public function listAll()
    {
        $programas = Programa::select(
            'programas.id',
            'programas.registro',
            'programas.tipo_programa',
            'programas.empresa',
            'programas.puestouno',
            'programas.puestodos',
            'programas.puestotres',
            'programas.puestocuatro',
            'programas.responsable',
            DB::raw('COUNT(CASE WHEN participantes.estado = "Postulante" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_postulantes'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Evaluando" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_evaluando'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Contratado" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_contratados'),
            DB::raw('COUNT(CASE WHEN participantes.estado = "Descartado" AND participantes.deleted_at IS NULL THEN 1 END) AS cantidad_descartados')
        )
            ->leftJoin('participantes', function ($join) {
                $join->on('programas.id', '=', 'participantes.id_programa')
                    ->whereNull('participantes.deleted_at'); /* Para no contar los participantes eliminados */
            })
            ->whereNull('programas.deleted_at') // Filtrar programas eliminados si usas soft delete
            ->groupBy(
                'programas.id',
                'programas.registro',
                'programas.tipo_programa',
                'programas.empresa',
                'programas.puestouno',
                'programas.puestodos',
                'programas.puestotres',
                'programas.puestocuatro',
                'programas.responsable'
            )
            ->orderBy('programas.registro', 'desc') // Ordenar por la fecha más reciente a la más antigua
            ->get();

        return response()->json(['data' => $programas]);
    }

    public function delete(Request $request)
    {
        $status = false;

        // Encuentra el programa con el id proporcionado
        $entity = Programa::find($request->id);

        if ($entity) {
            // Verifica si hay participantes asociados al programa
            $hasParticipants = $entity->Participantes()->exists();

            if (!$hasParticipants) {
                // Elimina el programa si no tiene participantes asociados
                if ($entity->delete()) {
                    $status = true;
                }
            } else {
                // Puedes devolver un mensaje de error si el programa tiene participantes
                return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el programa porque tiene participantes asociados.']);
            }
        } else {
            // Devuelve un mensaje de error si el programa no se encuentra
            return response()->json(['Success' => $status, 'Message' => 'Programa no encontrado.']);
        }

        return response()->json(['Success' => $status]);
    }

    public function store(Request $request)
    {
        $status = false;

        // Validación de los datos enviados
        $validator = Validator::make($request->all(), [
            'registro' => 'required',
            'tipo_programa' => 'required',
            'empresa' => 'required',
            'puestouno' => 'required',
            'responsable' => 'required',
        ]);


        // Verifica si la validación ha fallado
        if (!$validator->fails()) {
            // Si la validación es exitosa, prepara los datos para la creación del programa
            $data = [
                /* datos del programa */
                'registro' => $request->registro,
                'tipo_programa' => $request->tipo_programa,
                'empresa' => $request->empresa,
                'puestouno' => $request->puestouno,
                'puestodos' => $request->puestodos,
                'puestotres' => $request->puestotres,
                'puestocuatro' => $request->puestocuatro,
                'responsable' => $request->responsable,
                /* datos adicionales */
                /* 'postulantes' => $request->postulantes,
                'evaluando' => $request->evaluando,
                'contratados' => $request->contratados,
                'descartado' => $request->descartado, */
            ];
            // Crea el programa en la base de datos
            Programa::create($data);

            $status = true;
        }
        return $status ? redirect(route('auth.programa')) : redirect(route('auth.programa'))->withErrors($validator)->withInput();
    }

    public function partialView($id)
    {

        return view('auth.programa.Mantenimiento', ['Entity' => Programa::find($id)]);
    }

    public function updateData(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()) {
            $entity = Programa::find($request->id);
            $entity->registro = $request->registro;
            $entity->tipo_programa = $request->tipo_programa;
            $entity->empresa = $request->empresa;
            $entity->puestouno = $request->puestouno;
            $entity->puestodos = $request->puestodos;
            $entity->puestotres = $request->puestotres;
            $entity->puestocuatro = $request->puestocuatro;
            $entity->responsable = $request->responsable;

            /* Otros datos cantidad */
            /* $entity->postulantes = $request->postulantes;
            $entity->evaluando = $request->evaluando;
            $entity->contratados = $request->contratados;
            $entity->descartado = $request->descartado; */


            /* datos del estudiante  */
            /* $entity->dni = $request->dni;
            $entity->nombres = $request->nombres;
            $entity->apellidos = $request->apellidos;
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            $entity->estado = $request->estado;
            $entity->tipo = $request->tipo;
            $entity->sede = $request->sede; */


            if ($entity->save()) $status = true;
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    /* Para que se muestre los datos  en Participantes*/
    /* Hay posibilidad para listar en participantes */
    public function partialViewParticipantes($id)
    {
        return view('auth.programa.Participantes', ['Entity' => Programa::find($id)]);
    }


    public function storeParticipantes(Request $request)
    {
        // Validación de los datos enviados
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'especialidad' => 'required',
            'tipo' => 'required',
            'estado' => 'required',
            'sede' => 'required',
        ]);

        // Verifica si la validación ha fallado
        if ($validator->fails()) {
            return response()->json(['Success' => false, 'error' => $validator->errors()], 400);
        }

        // Verificar si ya existe un participante con el mismo DNI en el mismo programa y que no esté eliminado
        $existingParticipant = Participantes::where('id_programa', $request->id_programa)
            ->where('dni', $request->dni)
            ->whereNull('deleted_at') // Asumiendo que usas soft deletes y 'deleted_at' es la columna de eliminación
            ->first();

        if ($existingParticipant) {
            return response()->json(['Success' => false, 'Message' => 'Ya existe un participante con DNI ' . $request->dni . ' en este programa']);
        }

        // Si no existe, procede a crear el participante
        try {
            $data = [
                'id_programa' => $request->id_programa,
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'especialidad' => $request->especialidad,
                'tel' => $request->tel,
                'email' => $request->email,
                'estado' => $request->estado,
                'tipo' => $request->tipo,
                'sede' => $request->sede,
            ];

            Participantes::create($data);

            return response()->json(['Success' => true, 'message' => 'Participante creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'error' => 'Error al crear el Participante: ' . $e->getMessage()], 500);
        }
    }

    public function mostrarParticipantes(Request $request)
    {
        $id_programa = $request->input('id_programa');
        $participantes = DB::table('participantes as p')
            ->join('programas as pr', 'p.id_programa', '=', 'pr.id')
            ->select('p.id_participante', 'p.email', 'p.especialidad', 'pr.registro', 'p.sede', 'pr.tipo_programa', 'p.nombres', 'p.dni', 'p.apellidos', 'p.tel', 'p.tipo', 'p.estado')
            ->where('pr.id', $id_programa)
            ->whereNull('p.deleted_at')
            ->orderBy('p.created_at', 'DESC')
            ->get();
        /* dump($participantes); */
        return response()->json(['data' => $participantes]);
    }

    public function deletepar(Request $request)
    {
        $status = false;

        $entity = Participantes::find($request->id);

        if ($entity && $entity->delete()) {
            $status = true;
        }

        return response()->json(['Success' => $status]);
    }

    public function partialViewpar($id)
    {
        return view('auth.programa.ParticipantesEdit', ['Entity' => Participantes::find($id)]);
    }

    public function partialViewparEmpleabilidad($id)
    {
        return view('auth.programa.ParticipantesEditEmpleabilidad', ['Entity' => ParticipantesEmpleabilidad::find($id)]);
    }

    public function updateParticipanteInscrito(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()) {
            $entity = Participantes::find($request->id);
            $entity->especialidad = $request->especialidadEdit;
            $entity->tel = $request->telefonoEdit;
            $entity->email = $request->email;

            if ($entity->save()) $status = true;
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function updateParticipanteInscritoEmpleabilidad(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()) {
            $entity = ParticipantesEmpleabilidad::find($request->id);
            $entity->especialidad = $request->especialidadEdit;
            $entity->tel = $request->telefonoEdit;
            $entity->email = $request->email;

            if ($entity->save()) $status = true;
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function indexEmpleabilidad()
    {
        return view('auth.programa.index-empleablidad');
    }
    public function storeEmpleabilidad(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'registro' => 'required',
                'tipo_programa' => 'required',
                'responsable' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect(route('auth.programa-empleabilidad'))
                    ->withErrors($validator)
                    ->withInput();
            }

            ProgramaEmpleabilidad::create([
                'registro' => $request->registro,
                'tipo_programa' => $request->tipo_programa,
                'responsable' => $request->responsable,
            ]);

            return redirect(route('auth.programa-empleabilidad'))->with('success', 'Programa guardado correctamente.');
        } catch (\Exception $e) {
            return redirect(route('auth.programa-empleabilidad'))
                ->withErrors(['error' => 'Hubo un problema al guardar los datos: ' . $e->getMessage()])
                ->withInput();
        }
    }
    public function listAllEmpleabilidad()
    {
        $programas = ProgramaEmpleabilidad::select(
            'programas_empleabilidades.id',
            'programas_empleabilidades.registro',
            'programas_empleabilidades.tipo_programa',
            'programas_empleabilidades.responsable'
        )
            ->leftJoin('participantes_empleabilidad', function ($join) {
                $join->on('programas_empleabilidades.id', '=', 'participantes_empleabilidad.id_programa')
                    ->whereNull('participantes_empleabilidad.deleted_at');
            })
            ->whereNull('programas_empleabilidades.deleted_at')
            ->groupBy(
                'programas_empleabilidades.id',
                'programas_empleabilidades.registro',
                'programas_empleabilidades.tipo_programa',
                'programas_empleabilidades.responsable'
            )
            ->orderBy('programas_empleabilidades.registro', 'desc')
            ->get();
        return response()->json(['data' => $programas]);
    }
    public function partialViewEmpleabilidad($id)
    {
        return view('auth.programa.Mantenimiento_Empleabilidad', ['Entity' => ProgramaEmpleabilidad::find($id)]);
    }
    public function updateDataEmpleabilidad(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()) {
            $entity = ProgramaEmpleabilidad::find($request->id);
            $entity->registro = $request->registro;
            $entity->tipo_programa = $request->tipo_programa;
            $entity->responsable = $request->responsable;

            if ($entity->save()) $status = true;
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function deleteEmpleabilidad(Request $request)
    {
        $status = false;
        $entity = ProgramaEmpleabilidad::find($request->id);
        if ($entity) {
            $hasParticipants = $entity->Participantes()->exists();
            if (!$hasParticipants) {
                if ($entity->delete()) {
                    $status = true;
                }
            } else {
                return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el programa porque tiene participantes asociados.']);
            }
        } else {
            return response()->json(['Success' => $status, 'Message' => 'Programa no encontrado.']);
        }
        return response()->json(['Success' => $status]);
    }
    public function partialViewParticipantesEmpleabilidad($id)
    {
        return view('auth.programa.ParticipantesEmpleabilidad', ['Entity' => ProgramaEmpleabilidad::find($id)]);
    }
    public function storeParticipantesEmpleabilidad(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dni' => 'required',
            'nombres' => 'required',
            'apellidos' => 'required',
            'especialidad' => 'required',
            'tipo' => 'required',
            'sede' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['Success' => false, 'error' => $validator->errors()], 400);
        }
        $existingParticipant = ParticipantesEmpleabilidad::where('id_programa', $request->id_programa)
            ->where('dni', $request->dni)
            ->whereNull('deleted_at')
            ->first();
        if ($existingParticipant) {
            return response()->json(['Success' => false, 'Message' => 'Ya existe un participante con DNI ' . $request->dni . ' en este programa']);
        }
        try {
            $data = [
                'id_programa' => $request->id_programa,
                'dni' => $request->dni,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'especialidad' => $request->especialidad,
                'tel' => $request->tel,
                'email' => $request->email,
                'tipo' => $request->tipo,
                'sede' => $request->sede,
            ];
            ParticipantesEmpleabilidad::create($data);
            $dataArchive = [
                'dni_alumno' => $request->dni,
                'id_programa' => $request->id_programa,
                'created_at' => Carbon::now()
            ];
            StudentApplicationFiles::create($dataArchive);
            return response()->json(['Success' => true, 'message' => 'Participante creado correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'error' => 'Error al crear el Participante: ' . $e->getMessage()], 500);
        }
    }
    public function mostrarParticipantesEmpleabilidad(Request $request)
    {
        $id_programa = $request->input('id_programa');
        $participantes = DB::table('participantes_empleabilidad as p')
            ->join('programas_empleabilidades as pr', 'p.id_programa', '=', 'pr.id')
            ->leftJoin('student_application_files as saf', function ($join) {
                $join->on('p.dni', '=', 'saf.dni_alumno')
                    ->on('p.id_programa', '=', 'saf.id_programa')
                    ->whereNull('saf.deleted_at');
            })
            ->select(
                'p.id_participante',
                'p.email',
                'p.especialidad',
                'pr.registro',
                'p.sede',
                'pr.tipo_programa',
                'p.nombres',
                'p.dni',
                'p.apellidos',
                'p.tel',
                'p.tipo',
                'p.certified_status',
                'saf.id as saf_id',
                'saf.video_presentation',
                'saf.cv_pdf',
                'saf.created_at as saf_created_at',
            )
            ->where('pr.id', $id_programa)
            ->whereNull('p.deleted_at')
            ->orderBy('p.created_at', 'DESC')
            ->get();
        return response()->json(['data' => $participantes]);
    }
    public function deleteparEmpleabilidad(Request $request)
    {
        $status = false;
        $entity = ParticipantesEmpleabilidad::find($request->id);
        if ($entity && $entity->delete()) {
            StudentApplicationFiles::where('dni_alumno', $entity->dni)
                ->where('id_programa', $entity->id_programa)
                ->delete();
            $status = true;
        }

        return response()->json(['Success' => $status]);
    }
    public function generarCertificadoEmpleabilidad($id)
    {
        Carbon::setLocale('es');
        $entity = ParticipantesEmpleabilidad::find($id);
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
    public function validarEmpleabilidad(Request $request)
    {
        try {
            $updateData = ParticipantesEmpleabilidad::where('id_participante', $request->id)->update([
                'certified_status' => 1,
                'updated_at' => Carbon::now()
            ]);
            if ($updateData) {
                return response()->json(['Success' => true, 'message' => 'Actualización exitosa'], 200);
            } else {
                return response()->json(['message' => 'No se encontró el participante o no se pudo actualizar.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['Success' => false, 'error' => 'Error al crear el Participante: ' . $e->getMessage()], 500);
        }
    }
}
