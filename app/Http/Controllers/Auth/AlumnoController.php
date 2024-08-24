<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\Area;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\ExperienciaLaboral;
use BolsaTrabajo\ReferenciaLaboral;
use Illuminate\Support\Facades\Auth;
use BolsaTrabajo\AlumnoHabilidad;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;

class AlumnoController extends Controller
{
    public function index()
    {
        return view('auth.alumno.index');
    }

    /* public function list(Request $request)
    {
        if($request->mostrar == 'mostrar'){
            return response()->json(['data' => Alumno::with(['provincias', 'distritos', 'areas', 'educaciones'])
            ->orderBy('created_at', 'DESC')
            ->get() ]);
        }else if(isset($request->dni_apellido)){
            return response()->json(['data' => Alumno::with(['provincias', 'distritos', 'areas', 'educaciones'])
            ->where('dni', 'like', '%'.$request->dni_apellido.'%')
            ->orWhere('apellidos', 'like', '%'.$request->dni_apellido.'%')
            ->orderBy('created_at', 'DESC')
            ->limit(80)
            ->get() ]);
        }else{
            return response()->json(['data' => '']);
        }
    } */

    public function list(Request $request)
{
    $query = Alumno::with(['provincias', 'distritos', 'areas', 'educaciones'])
                    ->orderBy('created_at', 'DESC');
                    
    if ($request->mostrar == 'mostrar') {
        return response()->json(['data' => $query->get()]);
    } elseif (isset($request->dni_apellido)) {
        $query->where(function($q) use ($request) {
            $q->where('dni', 'like', '%'.$request->dni_apellido.'%')
              ->orWhere('apellidos', 'like', '%'.$request->dni_apellido.'%');
        });
        return response()->json(['data' => $query->limit(80)->get()]);
    } elseif (isset($request->fechasemestre) && !empty($request->fechasemestre)) {
        // Extrae el año del select fechasemestre
        $year = $request->fechasemestre;

        // Filtrar por año usando el campo `created_at`
        $query->whereYear('created_at', $year);
        return response()->json(['data' => $query->get()]);
    } else {
        return response()->json(['data' => []]);
    }
}

    // codigo hecho por marco
    public function print_cv_pdf($id)
    {
        $alumno = Alumno::find($id);
        $Areas = Area::all();
        $Provincias = Provincia::all();

        if($alumno != null){

            $Distritos = Distrito::where('provincia_id', $alumno->provincia_id)->get();
            $Educaciones = Educacion::where('alumno_id', $alumno->id)->get();
            $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $alumno->id)->get();

            $Habilidades = AlumnoHabilidad::where('alumno_id', $alumno->id)
                ->whereHas('habilidades', function ($query) { $query->whereNull('deleted_at'); })
                ->get();

            $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $alumno->id)->get();

            $data = array(
                'areas' => $Areas,
                'alumno' => Alumno::find($id),
                'habilidades' => $Habilidades,
                'distritos' => $Distritos,
                'educaciones' => $Educaciones,
                'experienciaLaboral' => $ExperienciaLaboral,
                'referenciaLaboral' => $ReferenciaLaboral
            );
            $pdf = PDF::loadView('auth.alumno.exports.cv_pdf', $data);
            /* $pdf = PDF::loadView('auth.alumno.exports.print_cv_pdf', $data); */
            /* return $pdf->download('CV-'.($alumno->nombres.' '.$alumno->apellidos).'.pdf'); */
            return $pdf->stream('CV-'.($alumno->nombres.' '.$alumno->apellidos).'.pdf');
        }

        return redirect()->to('/auth/alumno');
    }

    public function update(Request $request)
    {
        $status = false;
        $entity = Alumno::find($request->id);
        $entity->aprobado = $request->update_id;

        if($entity->save()) $status = true;

        return response()->json(['Success' => $status]);
    }

    public function delete(Request $request)
    {
        $status = false;
        $entity = Alumno::find($request->id);
        if($entity->delete()) $status = true;

        return response()->json(['Success' => $status]);
    }
}
