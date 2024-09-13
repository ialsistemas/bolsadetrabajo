<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Eventos;
use BolsaTrabajo\EventosAsistencia;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventosController extends Controller
{

    public function index(){ 
       
        return view('auth.eventos.index');
        
    }
      
    public function list_all()
    {
        return response()->json(['data' => Eventos::orderby('id', 'desc')->get()]);
    }

    public function partialView($id)
    {

        return view('auth.eventos.Mantenimiento', ['Entity' => Eventos::find($id)]);
    }

    
    /* GUARDAR EVENTO */
    public function store(Request $request)
    {
        $status = false;
        $message = '';

        $validator = Validator::make($request->all(), [
            'fecha_registro' => 'required',
            'nombre' => 'required',
        ]);

        if (!$validator->fails()) {
            // Buscar si existe un registro con la misma fecha y nombre
            $existingEvent = Eventos::where('fecha_registro', $request->fecha_registro)
                                    ->where('nombre', $request->nombre)
                                    ->first();

            if ($existingEvent) {
                // Registro ya existe, no se debe crear uno nuevo
                $message = 'Un registro con la misma fecha y nombre ya existe.';
            } else {
                // Crear un nuevo registro si no existe
                $data = [
                    'fecha_registro' => $request->fecha_registro,
                    'nombre' => $request->nombre,        
                ];

                Eventos::create($data);
                $status = true;
                $message = 'Registro creado exitosamente.';
            }
        } else {
            $message = 'Error de validación.';
        }

        return $status ? redirect(route('auth.eventos')) : redirect(route('auth.eventos'))->withErrors($validator)->withInput();
    }



    /* Store creacion de Eventos por PROCEDIMIENTO ALMACENADO brindado por el ingeniero */
    /* public function store(Request $request)
    {
        $status = false;
        $fecha_registro = $request->input('fecha_registro');
        $nombre = $request->input('nombre');
    
        try {
            // Ejecutar el procedimiento almacenado
            DB::select('CALL GRABAR(?, ?)', [
                $fecha_registro,
                $nombre,
            ]
        );
            $status = true;
            
            // Retornar respuesta JSON
            return response()->json([
                'Success' => $status,
            ]);
    
        } catch (\Exception $e) {
            // Manejo de errores
            \Log::error('Error al ejecutar el procedimiento almacenado GRABAR: ' . $e->getMessage());
            return response()->json([
                "response" => "error",
                "message" => "Ocurrió un error al procesar la solicitud. Por favor, inténtelo de nuevo más tarde."
            ], 500);
        }
    } */
    

    //ELIMINAR EVENTO
    public function delete(Request $request)
    {
        $status = false;
        
        // Encuentra el programa con el id proporcionado
        $entity = Eventos::find($request->id);

        if ($entity) {
            // Verifica si hay participantes asociados al programa
            $hasParticipants = $entity->EventosAsistencia()->exists();

            if (!$hasParticipants) {
                // Elimina el programa si no tiene participantes asociados
                if ($entity->delete()) {
                    $status = true;
                }
            } else {
                // Puedes devolver un mensaje de error si el programa tiene participantes
                return response()->json(['Success' => $status, 'Message' => 'No se puede eliminar el evento porque tiene participantes asociados.']);
            }
        } else {
            // Devuelve un mensaje de error si el programa no se encuentra
            return response()->json(['Success' => $status, 'Message' => 'Evento no encontrado.']);
        }

        return response()->json(['Success' => $status]);
    }

    public function update(Request $request)
    {
        $status = false;
        $message = '';

        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:eventos,id',
            'fecha_registro' => 'required|date',
            'nombre' => 'required|string',
        ]);

        if (!$validator->fails()) {
            $entity = Eventos::find($request->id);

            if ($entity) {
                // Verificar si ya existe otro registro con la misma fecha y nombre, excluyendo el actual
                $existingEvent = Eventos::where('fecha_registro', $request->fecha_registro)
                                        ->where('nombre', $request->nombre)
                                        ->where('id', '<>', $request->id)
                                        ->first();

                if ($existingEvent) {
                    $message = 'Un registro con la misma fecha y nombre ya existe.';
                } else {
                    // Actualizar el registro
                    $entity->fecha_registro = $request->fecha_registro;
                    $entity->nombre = $request->nombre;

                    if ($entity->save()) {
                        $status = true;
                        $message = 'Registro actualizado exitosamente.';
                    } else {
                        $message = 'Error al actualizar el registro.';
                    }
                }
            } else {
                $message = 'El registro no existe.';
            }
        } else {
            $message = 'Error de validación.';
        }

        return response()->json([
            'Success' => $status,
            'Message' => $message,
            'Errors' => $validator->errors()
        ]);
    }


    /* VER ASISTENTES */
    public function partialViewAsistentes($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = Eventos::find($id);
        // Pasar la entidad a la vista
        return view('auth.eventos.Asistentes', ['Entity' => $entity]);
    }
    

    /* Mostrar Participantes en Tabla al momento de abrir el modal LISTADO TABLA*/
    public function mostrarParticipantesAsistentes(Request $request)
    {
        $id_evento = $request->input('id_evento');

        // Consulta usando el modelo Eloquent
        $participantes = EventosAsistencia::join('eventos as ev', 'eventosasistencia.id_evento', '=', 'ev.id') // Unir con la tabla eventos
                            ->select('eventosasistencia.tipo','eventosasistencia.estado','eventosasistencia.dni', 'eventosasistencia.nombres', 'eventosasistencia.apellidos', 'eventosasistencia.email', 'eventosasistencia.tel', 'eventosasistencia.tipo', 'eventosasistencia.sede', 'eventosasistencia.especialidad', 'eventosasistencia.id') // Selecciona los campos necesarios
                            ->where('ev.id', $id_evento) // Filtrar por el id del evento
                            ->orderBy('eventosasistencia.created_at', 'DESC') // Ordenar por la fecha de creación
                            ->get();

        return response()->json(['data' => $participantes]);
    }


    //ELIMINAR ASISTENTES
    public function deleteAsistentes(Request $request)
    {
        $status = false;

        $entity = EventosAsistencia::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }


    /* ABRIR MODAL DE EDITAR ASISTENTES */
    public function partialViewEditAsistente($id)
    {
        // Asegúrate de que el ID es válido y que la entidad se encuentra en la base de datos
        $entity = EventosAsistencia::find($id);
        // Pasar la entidad a la vista
        return view('auth.eventos.EditarAsistentes', ['Entity' => $entity]);
    }
    
    //EDITAR ASISTENTES
    public function updateAsistentes(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = EventosAsistencia::find($request->id);
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            $entity->tipo = $request->tipo;
            $entity->sede = $request->sede;

            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function listA()
    {
        // Obtener todas las asistencias con los eventos relacionados
        $asistencias = EventosAsistencia::with('evento')
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($asistencia) {
                // Devolver todos los atributos de EventosAsistencia junto con el nombre del evento
                return [
                    'id' => $asistencia->id,
                    'dni' => $asistencia->dni,
                    'nombres' => $asistencia->nombres,
                    'apellidos' => $asistencia->apellidos,
                    'email' => $asistencia->email,
                    'especialidad' => $asistencia->especialidad,
                    'sede' => $asistencia->sede,
                    'tel' => $asistencia->tel,
                    'tipo' => $asistencia->tipo,
                    'id_evento' => $asistencia->id_evento,
                    //Evento traer datos 
                    'nombre' => $asistencia->evento ? $asistencia->evento->nombre : null,
                    'fecha_registro' => $asistencia->evento ? $asistencia->evento->fecha_registro : null,
                ];
            });

        // Devolver los datos en formato JSON
        return response()->json(['data' => $asistencias]);
    }
}    