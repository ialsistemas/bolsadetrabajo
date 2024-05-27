<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Habilidad;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HabilidadController extends Controller
{
    public function index()
    {
        return view('auth.habilidad.index');
    }

    public function index_profesional()
    {
        return view('auth.habilidad.profesional.index');
    }

    public function list_all(Request $request)
    {
        return response()->json(['data' => Habilidad::where('tipo', $request->tipo)->orderby('id', 'desc')->get()]);
    }

    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = Habilidad::find($id);

        return view('auth.habilidad._Mantenimiento', ['Entity' => $entity]);
    }

    public function store(Request $request)
    {
        $status = false;

        if($request->id != 0)
            $entity = Habilidad::find($request->id);
        else
            $entity = new Habilidad();

        $validator = Validator::make($request->all(), [
            'nombre' => ['required','unique:habilidads,nombre,'.($request->id != 0 ? $request->id : "NULL").',id,tipo,'.$request->tipo.',deleted_at,NULL']
        ]);

        if (!$validator->fails()){
            $entity->nombre = trim($request->nombre);
            $entity->tipo = $request->tipo;
            if($entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Habilidad::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }
}
