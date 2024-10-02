<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\User;
use BolsaTrabajo\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa la clase Auth
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsuariosController extends Controller

{
    public function index()
    {
        if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR) {
            return view('auth.usuarios.index');
        }

        // Opcionalmente, podrías manejar el caso en que la condición no se cumple
        return redirect('/auth/inicio'); // Redirige a una página predeterminada si la condición no se cumple
    }
    
    public function list_all()  
    {
        return response()->json([
            'data' => User::with('profile') // Cambia 'profile' por el nombre correcto de la relación
                ->orderBy('id', 'desc')
                ->get()
        ]);
    }


    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = User::find($id);
        $Profiles = Profile::orderBy('name', 'asc')->get();

        return view('auth.usuarios._Mantenimiento', ['Entity' => $entity, 'Profiles' => $Profiles]);
    }

    public function store(Request $request)
    {
        $status = false;

        // Validación de los campos 'nombres', 'email' y otros
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|unique:users,nombres,' . ($request->id ?? 'NULL') . ',id,deleted_at,NULL',
            'email' => 'required|unique:users,email,' . ($request->id  ?? 'NULL') . ',id,deleted_at,NULL',
            'password' => 'nullable|min:6', // Se valida solo si está presente
            'profile_id' => 'required',
            'estado' => 'required|in:1,2'
        ]);

        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'Success' => $status,
                'Errors' => $validator->errors()
            ]);
        }

        // Encontrar o crear la entidad User
        if ($request->id) {
            $entity = User::find($request->id);
            if (!$entity) {
                return response()->json([
                    'Success' => $status,
                    'Errors' => ['User not found.']
                ]);
            }
            // Solo actualizar la contraseña si se proporciona una nueva
            if ($request->has('password') && trim($request->password) != '') {
                $entity->password = bcrypt($request->password);
            }
        } else {
            $entity = new User();
            // Encriptar la contraseña si se está creando un nuevo usuario
            if ($request->has('password') && trim($request->password) != '') {
                $entity->password = bcrypt($request->password);
            }
        }

        // Asignar valores a la entidad
        $entity->nombres = trim($request->nombres);
        $entity->email = trim($request->email);
        $entity->profile_id = $request->profile_id;
        $entity->estado = $request->estado;

        // Guardar la entidad
        if ($entity->save()) {
            $status = true;
        }

        // Retornar la respuesta en formato JSON
        return response()->json([
            'Success' => $status,
            'Errors' => $validator->errors()
        ]);
    }



    

    public function delete(Request $request)
    {
        $status = false;

        $entity = User::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }

    
}