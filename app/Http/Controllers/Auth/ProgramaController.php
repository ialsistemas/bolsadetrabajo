<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Programa;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProgramaController extends Controller
{
    public function index()
    {
        return view('auth.programa.index');
    }

    public function listAll()
{
    // Obtener todos los programas ordenados por 'registro' en orden descendente
    $programas = Programa::orderBy('id', 'desc')->get();

    // Devolver los datos en formato JSON
    return response()->json(['data' => $programas]);
}
public function delete(Request $request)
    {
        $status = false;

        $entity = Programa::find($request->id);

        if($entity->delete()) $status = true;

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
            /* 'puestodos' => 'required',
            'puestotres' => 'required',
            'puestocuatro' => 'required', */
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
                'postulantes' => $request->postulantes,
                'evaluando' => $request->evaluando,
                'contratados' => $request->contratados,
                'descartado' => $request->descartado,

                 
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
        if (!$validator->fails()){
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
            $entity->postulantes = $request->postulantes;
            $entity->evaluando = $request->evaluando;
            $entity->contratados = $request->contratados;
            $entity->descartado = $request->descartado;


            /* datos del estudiante  */
            /* $entity->dni = $request->dni;
            $entity->nombres = $request->nombres;
            $entity->apellidos = $request->apellidos;
            $entity->tel = $request->tel;
            $entity->email = $request->email;
            $entity->estado = $request->estado;
            $entity->tipo = $request->tipo;
            $entity->sede = $request->sede; */


            if($entity->save()) $status = true;            
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }


}