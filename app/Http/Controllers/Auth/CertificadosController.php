<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Certificados;
use BolsaTrabajo\CertificadosAlumnos;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class CertificadosController extends Controller
{

    public function index()
    {
        if (Auth::guard('web')->user()->profile_id == \BolsaTrabajo\App::$PERFIL_DESARROLLADOR){

            return view('auth.certificados.index');
        }

        return redirect('/auth/inicio'); 
    }

    /* TALLER */
    public function list_all()
    {
        return response()->json(['data' => Certificados::orderby('id', 'desc')->get()]);
    }

    /* VER  PARTICIPANTES DE CADA TALLER */
    public function partialView($id)
    {
        $entity = null;

        if($id != 0) $entity = Certificados::find($id);

        return view('auth.certificados.Participantes', ['Entity' => $entity]);
    }



    /* Abrir modal para ver participantes de cada taller */
    public function mostrarParticipantes(Request $request)
    {
        $request->validate([
            'id_certificados' => 'required|integer|exists:certificados,id'
        ]);

        $id_certificados = $request->input('id_certificados');

        $participantes = DB::table('certificadosalumnos as ca')
            ->join('certificados as c', 'ca.id_certificados', '=', 'c.id')
            ->select('c.nombre','c.fecha','ca.id','ca.dni', 'ca.nombres', 'ca.apellidos', 'ca.especialidad', 'ca.tel', 'ca.email')
            ->where('c.id', $id_certificados)
            ->whereNull('ca.deleted_at')
            ->orderBy('ca.created_at', 'DESC')
            ->get();

        return response()->json(['data' => $participantes]);
    }



    /* ABRIR CERTIFICADO */
    public function partialViewCertificado($id)
    {
        try {
            // Usamos findOrFail para obtener el alumno junto con los datos del taller (nombre y fecha)
            $Entity = CertificadosAlumnos::select('id', 'id_certificados','dni', 'nombres', 'apellidos', 'especialidad', 'tel', 'email')
                            ->with('certificado:id,nombre,fecha') // Cargamos la relación "certificado"
                            ->findOrFail($id);
    
            // Verificamos si el certificado existe
            if ($Entity->certificado) {
                // Accedemos al nombre del taller y la fecha
                $nombreTaller = $Entity->certificado->nombre;
                $fechaTaller = $Entity->certificado->fecha;
            } else {
                // Si no existe el certificado asociado
                $nombreTaller = null;
                $fechaTaller = null;
            }
    
            // Retornamos la vista con los datos del alumno y del taller
            return view('auth.certificados.Certificado', [
                'Entity' => $Entity,
                'nombreTaller' => $nombreTaller,
                'fechaTaller' => $fechaTaller
            ]);
    
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Si el alumno no se encuentra, retornamos un mensaje de error
            return response()->json(['error' => 'Empleado no encontrado.'], 404);
        }
    }
    

    /* Me quede aqui, falta terminar */
    public function deleteAlumno(Request $request)
    {
        $status = false;

        $entity = CertificadosAlumnos::find($request->id);

        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }


    public function store(Request $request)
    {
        $status = false;
        
        // Validación de los datos enviados
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'fecha' => 'required',
            'horas' => 'required',
            'creditos' => 'required',
        ]);
        
        if (!$validator->fails()) {

            $data = [
                'nombre' => $request->nombre,
                'fecha' => $request->fecha,
                'horas' => $request->horas,
                'creditos' => $request->creditos,          
            ];
            Certificados::create($data);
    
            $status = true;
        }
        return $status ? redirect(route('auth.certificados')) : redirect(route('auth.certificados'))->withErrors($validator)->withInput();

    }



}