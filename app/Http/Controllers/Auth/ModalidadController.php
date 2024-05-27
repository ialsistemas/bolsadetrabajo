<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Modalidad;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ModalidadController extends Controller
{
    public function index()
    {
        return view('auth.modalidad.index');
    }

    public function list_all()
    {
        return response()->json(['data' => Modalidad::orderby('id', 'desc')->get()]);
    }

    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = Modalidad::find($id);

        return view('auth.modalidad._Mantenimiento', ['Entity' => $entity]);
    }

    public function store(Request $request)
    {
        $status = false;

        if($request->id != 0)
            $entity = Modalidad::find($request->id);
        else
            $entity = new Modalidad();

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|unique:modalidads,nombre,'.($request->id != 0 ? $request->id : "NULL").',id,deleted_at,NULL'
        ]);

        if (!$validator->fails()){
            $entity->nombre = trim($request->nombre);
            if($entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function delete(Request $request)
    {
        $status = false;

        $entity = Modalidad::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }
}
