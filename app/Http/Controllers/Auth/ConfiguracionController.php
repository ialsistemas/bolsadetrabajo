<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Configuracion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ConfiguracionController extends Controller
{
    public function index()
    {
        // Obtener los datos de la empresa
        $configuracion = Configuracion::first(); // o encontrar por ID si es necesario
    
        // Pasar los datos a la vista
        return view('auth.configuracion.index', compact('configuracion'));
    }
    public function list_all()
    {
        return response()->json(['data' => Configuracion::orderby('id', 'desc')->get()]);
    }


    public function update(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tel' => 'required|string|max:20',
            'facebook' => 'required|string|max:255',
            'instagram' => 'required|string|max:255',
            'linkedin' => 'required|string|max:255',
            'banneradmin' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'banneruser' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Obtener el modelo de la empresa
        $configuracion = Configuracion::first(); // o encontrar por ID si es necesario

        // Actualizar los datos
        $configuracion->nombre = $request->nombre;
        $configuracion->email = $request->email;
        $configuracion->tel = $request->tel;
        $configuracion->facebook = $request->facebook;
        $configuracion->instagram = $request->instagram;
        $configuracion->linkedin = $request->linkedin;

        // Manejar la subida del logo si se proporciona
        if ($request->file('logo')) {
            $random = 'logo';
            $logo = uniqid($random . "_") . '.' . $request->file('logo')->getClientOriginalExtension();
            $logoPath = 'uploads/fotos/' . $logo;

            $request->file('logo')->move(public_path('uploads/fotos'), $logo);

            $configuracion->logo = $logoPath;
        }

        // Manejar la subida del banner admin si se proporciona
        if ($request->file('banneradmin')) {
            $random = 'banneradmin';
            $bannerAdmin = uniqid($random . "_") . '.' . $request->file('banneradmin')->getClientOriginalExtension();
            $bannerAdminPath = 'uploads/fotos/' . $bannerAdmin;

            $request->file('banneradmin')->move(public_path('uploads/fotos'), $bannerAdmin);

            $configuracion->banneradmin = $bannerAdminPath;
        }

        // Manejar la subida del banner user si se proporciona
        if ($request->file('banneruser')) {
            $random = 'banneruser';
            $bannerUser = uniqid($random . "_") . '.' . $request->file('banneruser')->getClientOriginalExtension();
            $bannerUserPath = 'uploads/fotos/' . $bannerUser;

            $request->file('banneruser')->move(public_path('uploads/fotos'), $bannerUser);

            $configuracion->banneruser = $bannerUserPath;
        }

        // Guardar los cambios
        $configuracion->save();

        // Redireccionar o retornar con un mensaje de éxito
        return redirect()->route('auth.configuracion')->with('success', 'Datos actualizados correctamente.');
    }


}
