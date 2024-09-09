<?php

namespace BolsaTrabajo\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use Illuminate\Http\Request;
use Carbon\Carbon;
use BolsaTrabajo\EventosAsistencia;
use BolsaTrabajo\Eventos;
use BolsaTrabajo\User;
use Illuminate\Validation\Rule; // Importa la clase Rule
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EventosAsistenciaController extends Controller
{

    public function index(){ 
        // Obtener la fecha actual sin la hora
        $fechaActual = Carbon::now()->format('Y-m-d');
        
        // Filtrar eventos que estén activos y cuya fecha_registro sea exactamente igual a la fecha actual
        $eventos = Eventos::where('estado', 'activo')
                          ->whereDate('fecha_registro', $fechaActual)
                          ->get();
        
        $User = Auth::guard('web')->user();
        $userId = $User->id; // Extraer el ID del usuario
        // Pasar los eventos filtrados a la vista
        return view('auth.eventosasistencia.index', ['eventos' => $eventos, 'userId' => $userId]);
    }


    public function store(Request $request)
    {
        // Definir reglas de validación
        $validator = Validator::make($request->all(), [
            'id_evento' => 'required|exists:eventos,id',
            'nombres' => [
                'required',
                'string',
                Rule::unique('eventosasistencia')
                    ->where(function ($query) use ($request) {
                        return $query->where('id_evento', $request->id_evento)
                                     ->whereNull('deleted_at'); // Asegurarse de que el participante no esté eliminado
                    })
            ],
            'apellidos' => 'required|string',
            'especialidad' => 'required|string',
            'sede' => 'required|string',
            'id_user' => 'required|exists:users,id',
        ], [
            'nombres.unique' => 'El participante ya está registrado en este evento.',
        ]);

        if ($validator->fails()) {
            // Redirigir con errores de validación si los hay
            return redirect()->route('auth.eventosasistencia')
                            ->withErrors($validator)
                            ->withInput();
        }

        // Preparar datos para la creación
        $data = [
            'id_evento' => $request->id_evento,
            'dni' => $request->dni,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'especialidad' => $request->especialidad,
            'tel' => $request->tel,
            'email' => $request->email,
            'sede' => $request->sede,
            'id_user' => $request->id_user,
        ];

        // Crear el registro en la base de datos
        EventosAsistencia::create($data);

        // Redirigir con un mensaje de éxito
        return redirect()->route('auth.eventosasistencia')
                        ->with('success', 'Registro Exitoso.');
    }


    
    public function update(Request $request)
    {
        $status = false;
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);
        if (!$validator->fails()){
            $entity = EventosAsistencia::find($request->id);
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            /* $entity->tipo = $request->tipo; */
            $entity->sede = $request->sede;

            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }
    
    
}