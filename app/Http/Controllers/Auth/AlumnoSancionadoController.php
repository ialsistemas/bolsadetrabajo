<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Condicion;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\AlumnoSancionado;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AlumnoSancionadoController extends Controller
{
    public function index()
        {
        if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR) {
            return view('auth.alumnosancionado.index');
        } // Opcionalmente, podrías manejar el caso en que la condición no se cumple
            return redirect('/auth/inicio'); // Redirige a una página predeterminada si la condición no se cumple
        }

        public function list_all(Request $request)
        {
            // Asegúrate de que se pase el parámetro de solicitud
            $ruc_dni = $request->ruc_dni;
            $actividad_eco_filter_id = $request->actividad_eco_filter_id;
        
            // Inicializar la consulta base
            $query = DB::table('alumnosancionado')
                ->join('alumnos', 'alumnosancionado.alumno_id', '=', 'alumnos.id')
                ->select('alumnosancionado.*', 'alumnos.dni', 'alumnos.nombres', 'alumnos.apellidos')
                ->orderBy('alumnosancionado.id', 'desc');
        
            // Aplicar filtros según los parámetros recibidos
            if (!empty($ruc_dni)) {
                $query->where('alumnos.dni', 'like', '%'.$ruc_dni.'%');
            }
      
            else if (!empty($actividad_eco_filter_id)) {
                $query->where('alumnosancionado.estado', 'like', '%'.$actividad_eco_filter_id.'%');
            }

            else if ($request->mostrar == 'mostrar') {
                return response()->json(['data' => $query->get()]);
            }
        
            // Obtener los resultados
            $sanciones = $query->get();
        
            // Devolver la respuesta en formato JSON
            return response()->json(['data' => $sanciones]);
        }
        


    public function partialViewSancionado($id)
        {
            return view('auth.alumnosancionado.Mantenimiento', ['Entity' => Alumno::find($id)]);
        }


    /* Para Ingresar sancion y cambiar aprobado a numero 3 - el 3 es una verificacion que bloquea al alumno */
    public function store(Request $request)
        {
            // Validación de los datos enviados
            $validator = Validator::make($request->all(), [
                'motivo' => 'required',
                'alumno_id' => 'required|exists:alumnos,id', // Validación adicional
            ]);

            // Retorna error si la validación falla
            if ($validator->fails()) {
                return response()->json([
                    'Success' => false,
                    'error' => 'Validación fallida',
                    'details' => $validator->errors()
                ], 400);
            }

            try {
                // Comprobar si ya existe un registro con el mismo alumno_id y estado Activo
                $existingRecord = AlumnoSancionado::where('alumno_id', $request->alumno_id)
                                                ->where('estado', 'Activo') // Asegúrate de usar el estado correcto
                                                ->first();

                if ($existingRecord) {
                    return response()->json([
                        'Success' => false,
                        'error' => 'Ya existe una sanción activa para este alumno'
                    ]); 
                }

                // Datos para crear el nuevo registro
                $data = [
                    'alumno_id' => $request->alumno_id,
                    'motivo' => $request->motivo,
                    'estado' => 'Activo' // Asumiendo que deseas establecer el estado aquí
                ];

                // Crear el nuevo registro en AlumnoSancionado
                AlumnoSancionado::create($data);

                // Actualizar el campo 'aprobado' en la tabla Alumno
                $alumno = Alumno::find($request->alumno_id);

                if ($alumno) {
                    $alumno->aprobado = 3;
                    $alumno->save();
                } else {
                    // Si no se encuentra el alumno, puedes manejarlo según tu necesidad
                    return response()->json([
                        'Success' => false,
                        'error' => 'Alumno no encontrado'
                    ], 404);
                }

                return response()->json([
                    'Success' => true,
                    'message' => 'Sanción creada correctamente y alumno actualizado'
                ]);

            } catch (\Exception $e) {
                return response()->json([
                    'Success' => false,
                    'error' => 'Error al crear la sanción o actualizar el alumno: ' . $e->getMessage()
                ], 500);
            }
        }


    public function show($id)
        {
            $alumnoSancionado = AlumnoSancionado::find($id);

            if ($alumnoSancionado) {
                // Accede al alumno asociado
                $alumno = $alumnoSancionado->alumno;

                return response()->json([
                    'Success' => true,
                    'alumnoSancionado' => $alumnoSancionado,
                    'alumno' => $alumno
                ]);
            } else {
                return response()->json([
                    'Success' => false,
                    'error' => 'Alumno Sancionado no encontrado'
                ], 404);
            }
        }

    public function update(Request $request)
    {
        $status = false;       
        try {
            // Buscar la entidad AlumnoSancionado
            $entity = AlumnoSancionado::find($request->id);

            if (!$entity) {
                return response()->json([
                    'Success' => false,
                    'error' => 'Entidad no encontrada'
                ], 404);
            }

            // Actualizar el estado de la entidad
            $entity->estado = $request->estado;
            $entity->save();

            // Usar la relación para acceder al alumno
            $alumno = $entity->alumno;

            if (!$alumno) {
                return response()->json([
                    'Success' => false,
                    'error' => 'Alumno no encontrado'
                ], 404);
            }

            $alumno->aprobado = 1; // Cambia el valor según tu lógica de negocio
            $alumno->save();

            return response()->json([
                'Success' => true,
                'message' => 'Sanción actualizada correctamente y alumno actualizado'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'Success' => false,
                'error' => 'Error al actualizar la sanción o el alumno: ' . $e->getMessage()
            ], 500);
        }
    }


    

    
}