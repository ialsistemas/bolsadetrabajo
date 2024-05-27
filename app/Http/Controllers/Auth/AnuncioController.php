<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AnuncioController extends Controller
{
    public function index()
    {
        return view('auth.anuncio.index');
    }

    public function list()
    {
        return response()->json(['data' => Anuncio::orderby('created_at', 'desc')->get()]); 
    }

    public function store(Request $request)
    {
        $status = false;
        $random = Str::upper(str_random(4)); $foto = null;
        if($request->file('banner') != null){
            $foto = uniqid($random . "_") . '.' . $request->file('banner')->getClientOriginalExtension();
        }
        $validator = Validator::make($request->all(), [
            'titulo' => 'required',
            'fecha_desde' => 'required',
            'vigencia' => 'required',
            'banner' => 'required|mimes:jpeg,png'
        ]);
        if (!$validator->fails()){
            $data = [
                'titulo' => $request->titulo,
                'enlace' => $request->enlace,
                'mostrar' => $request->fecha_desde,
                'vigencia' => $request->vigencia,
                'banner' => 'uploads/anuncios/'.$foto
            ];
            Anuncio::create($data);

            if ($request->file('banner') != null)
                $request->file('banner')->move('uploads/anuncios', $foto);

            $status = true;
        }
        return $status ? redirect(route('auth.anuncio')) : redirect(route('auth.anuncio'))->withErrors($validator)->withInput();
    }
  
    public function delete(Request $request)
    {
        $status = false;
        $entity = Anuncio::find($request->id);
        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }
}
