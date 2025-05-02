<?php

namespace BolsaTrabajo\Http\Controllers\App;

use BolsaTrabajo\Alumno;
use BolsaTrabajo\AlumnoHabilidad;
use BolsaTrabajo\App;
use BolsaTrabajo\Area;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\ExperienciaLaboral;
use BolsaTrabajo\Habilidad;
use BolsaTrabajo\Provincia;
use BolsaTrabajo\ReferenciaLaboral;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class AlumnoController extends Controller
{
    public function index()
    {
        $Alumno = Auth::guard('alumnos')->user();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('provincia_id', $Alumno->provincia_id)->get();
        $Educaciones = Educacion::where('alumno_id', $Alumno->id)->orderBy('estudio_inicio', 'DESC')->get(); //se añadió desc order by para que ordene segun la fecha de mayo a menor
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_laburo', 'DESC')->get();
        foreach ($ExperienciaLaboral as $exp) {
            $exp->encrypted_id = Crypt::encryptString($exp->id);
        }
        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_curso', 'DESC')->get(); // se añadio tambien
        $Habilidades = AlumnoHabilidad::where('alumno_id', $Alumno->id)
            ->whereHas('habilidades', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();
        $Anios =  range(date('Y'), date('Y') - 21);
        array_push($Anios, "En Curso");
        $errors = Alumno::ValidatePerfilAlumno();
        $modificationNotice = 0;
        foreach ($ExperienciaLaboral as $exp) {
            if ($exp->descripcion == strip_tags($exp->descripcion)) {
                $modificationNotice = 1;
                break;
            }
        }
        $modificationNoticePerfil = 0;
        if ($Alumno->perfil_profesional == strip_tags($Alumno->perfil_profesional)) {
            $modificationNoticePerfil = 1;
        }
        return view('app.alumno.index', [
            'provincias' => $Provincias, 'distritos' => $Distritos, 'areas' => $Areas, 'alumno' => $Alumno, 'educaciones' => $Educaciones,
            'experienciaLaboral' => $ExperienciaLaboral, 'referenciaLaboral' => $ReferenciaLaboral, 'habilidades' => $Habilidades, 'anios' => $Anios, 'errors' => $errors, 'modificationNotice' => $modificationNotice, 'modificationNoticePerfil' => $modificationNoticePerfil
        ]);
    }

    public function experienciaLaboral($id)
    {
        try {
            $id = Crypt::decryptString($id);
            $Alumno = Auth::guard('alumnos')->user();
            $experienciaData = ExperienciaLaboral::where('id', $id)->where('alumno_id', $Alumno->id)->first();
            if ($experienciaData) {
                return view('app.alumno.experienciaLaboralView')->with('alumno', $Alumno)->with('experienciaData', $experienciaData);
            } else {
                return redirect()->route('alumno.perfil');
            }
        } catch (DecryptException $e) {
            return redirect()->route('alumno.perfil');
        }
    }
    public function newExperienciaLaboral()
    {
        $Alumno = Auth::guard('alumnos')->user();
        $experienciaData = null;
        return view('app.alumno.experienciaLaboralView')->with('alumno', $Alumno)->with('experienciaData', $experienciaData);
    }

    // function hecho por marco
    public function donwloadCValumno()
    {
        $Alumno = Auth::guard('alumnos')->user();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $Distritos = Distrito::where('provincia_id', $Alumno->provincia_id)->get();

        $Educaciones = Educacion::where('alumno_id', $Alumno->id)->orderBy('estudio_inicio', 'DESC')->get(); // se añadio 
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_laburo', 'DESC')->whereNull('deleted_at')->get();
        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_curso', 'DESC')->get(); //se añadio 
        $Habilidades = AlumnoHabilidad::where('alumno_id', $Alumno->id)
            ->whereHas('habilidades', function ($query) {
                $query->whereNull('deleted_at');
            })
            ->get();

        $Anios =  range(date('Y'), date('Y') - 21);
        array_push($Anios, "En Curso");

        $errors = Alumno::ValidatePerfilAlumno();

        $pdf = PDF::loadView('app.alumno.cv',  [
            'provincias' => $Provincias, 'distritos' => $Distritos, 'areas' => $Areas, 'alumno' => $Alumno, 'educaciones' => $Educaciones,
            'experienciaLaboral' => $ExperienciaLaboral, 'referenciaLaboral' => $ReferenciaLaboral, 'habilidades' => $Habilidades, 'anios' => $Anios, 'errors' => $errors
        ]);
        // $pdf = PDF::loadHTML('<h1>Test</h1>');
        return $pdf->stream();
        /*return view('app.alumno.cv')->with('provincias', $Provincias)->with('distritos', $Distritos)->with('areas', $Areas)->with('alumno', $Alumno)->with('educaciones', $Educaciones)->with('experienciaLaboral', $ExperienciaLaboral)->with('referenciaLaboral', $ReferenciaLaboral)->with('habilidades', $Habilidades)->with('anios', $Anios)->with('errors', $errors);*/
    }
    public function store(Request $request)
    {

        $status = false;
        $Alumno = Auth::guard('alumnos')->user();

        $request->merge([
            'fecha_nacimiento' => Carbon::createFromFormat("d/m/Y", $request->fecha_nacimiento)->format('Y-m-d')
        ]);

        $validator = Validator::make($request->all(), [
            // 'dni' => 'required|unique:alumnos,dni,'.($Alumno->id != 0 ? $Alumno->id : "NULL").',id,deleted_at,NULL',
            'fecha_nacimiento' => 'required|date',
            'provincia_id' => 'required',
            'distrito_id' => 'required',
            'telefono' => 'required|digits:9',
            'email' => 'required|email',
            'egresado' => 'required',
            'area_id' => 'required'
        ]);

        if (!$validator->fails()) {

            $random = Str::upper(str_random(4));
            $foto = null;
            $hoja_de_vida = null;

            if ($request->filled('imagen_recortada_base64')) {
                $imagenBase64 = $request->input('imagen_recortada_base64');
                if (preg_match('/^data:image\/(\w+);base64,/', $imagenBase64, $type)) {
                    $imagenBase64 = substr($imagenBase64, strpos($imagenBase64, ',') + 1);
                    $extension = strtolower($type[1]);
                    if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                        return back()->with('error', 'Formato de imagen no soportado.');
                    }
                    $imagenBase64 = base64_decode($imagenBase64);
                    if ($imagenBase64 === false) {
                        return back()->with('error', 'Error al decodificar la imagen.');
                    }
                    if (strlen($imagenBase64) > 10 * 1024 * 1024) {
                        return back()->with('error', 'La imagen no debe superar los 10MB.');
                    }
                    $nombreArchivo = uniqid('img_') . '.' . $extension;
                    $ruta = public_path('uploads/alumnos/fotos/' . $nombreArchivo);
                    file_put_contents($ruta, $imagenBase64);
                    $Alumno->foto = $nombreArchivo;
                    $Alumno->save();
                } else {
                    return back()->with('error', 'Formato de imagen incorrecto.');
                }
            }

            if ($request->file('hoja_de_vida') != null) {
                $hoja_de_vida = uniqid($random . "_") . '.' . $request->file('hoja_de_vida')->getClientOriginalExtension();
            }

            $Alumno = Alumno::find($Alumno->id);

            if (!$foto) $foto = $Alumno->foto;
            if (!$hoja_de_vida) $hoja_de_vida = $Alumno->hoja_de_vida;

            $Alumno->tipo_documento = $request->tipo_documento;
            $Alumno->dni = $request->dni;
            $Alumno->fecha_nacimiento = $request->fecha_nacimiento;
            $Alumno->genero = $request->genero;
            $Alumno->estado_civil = $request->estado_civil;
            $Alumno->nacionalidad = $request->nacionalidad;
            $Alumno->direccion = $request->direccion;
            $Alumno->provincia_id = $request->provincia_id;
            $Alumno->distrito_id = $request->distrito_id;
            $Alumno->telefono = $request->telefono;
            $Alumno->email = $request->email;
            $Alumno->perfil_profesional = $request->perfil_profesional;
            $Alumno->curso_talleres = $request->curso_talleres;
            $Alumno->referentes_carrera = $request->referentes_carrera;
            $Alumno->egresado = $request->egresado;
            $Alumno->anio_egreso = $request->anio_egreso;
            $Alumno->area_id = $request->area_id;

            $Alumno->presentacion = $request->presentacion;
            $Alumno->salario = $request->salario;
            $Alumno->disponibilidad = $request->disponibilidad;

            $Alumno->foto = $foto;
            $Alumno->hoja_de_vida = $hoja_de_vida;

            if ($Alumno->save()) {
                if ($request->file('foto') != null)
                    //$request->file('foto')->storeAs('public/uploads/alumnos/fotos', $foto);
                    $request->file('foto')->move('uploads/alumnos/fotos', $foto);

                if ($request->file('hoja_de_vida') != null)
                    $request->file('hoja_de_vida')->move('uploads/alumnos/archivos', $hoja_de_vida);

                $status = true;
            }
        }
        return response()->json(['Success' => $status, 'Errors' => $validator->errors(), 'Alumno' => $Alumno, 'Edad' => ($request->fecha_nacimiento != null  && $request->fecha_nacimiento < Carbon::now()->format('Y-m-d')) ? (Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'))->diffInYears(Carbon::createFromFormat('Y-m-d', $request->fecha_nacimiento))) : "-"]);
    }

    public function educacion($id)
    {
        $entity = null;

        $Anios = range(date('Y'), date('Y') - 30);
        array_push($Anios, "En Curso");

        if ($id != 0) {
            $entity = Educacion::find($id);
            if ($entity != null && $entity->alumno_id != Auth::guard('alumnos')->user()->id) {
                $entity = null;
            }
        }

        $Areas = Area::all();

        return view('app.alumno._educacion', ['areas' => Area::all(), 'anios' => $Anios, 'Educacion' => $entity, 'Areas' => $Areas]);
    }

    public function educaciones()
    {
        return response()->json(['data' => Educacion::with('areas')->where('alumno_id', Auth::guard('alumnos')->user()->id)->get()]);
    }

    public function educacion_store(Request $request)
    {
        $status = false;

        $request->merge([
            'anio' =>  $request->estado == App::$TIPO_ALUMNO ? "En Curso" : $request->anio
        ]);

        if ($request->id != 0) {
            $Entity = Educacion::where('id', $request->id)->where('alumno_id', Auth::guard('alumnos')->user()->id)->first();
            if (!$Entity)
                return response()->json(['Success' => $status, 'Message' => 'Información no encontrada o borrada']);
        } else {
            $Entity = new Educacion();
        }

        $validator = Validator::make($request->all(), [
            'institucion' => 'required',
            'area_id' => 'required',
            'estado' => 'required|digits:1',
            'inicio_estudio' => 'required',
            // 'fin_estudio' => 'required',
        ]);

        if (!$validator->fails()) {

            $Entity->alumno_id = Auth::guard('alumnos')->user()->id;
            $Entity->institucion = $request->institucion;
            $Entity->area_id = $request->area_id;
            $Entity->estado = $request->estado == App::$TIPO_TITULADO ? "Titulado" : ($request->estado == App::$TIPO_EGRESADO ?  "Egresado" : "Estudiante");
            $Entity->anio = $request->anio;
            $Entity->estudio_inicio = $request->inicio_estudio;
            $Entity->estudio_fin = $request->fin_estudio;
            $Entity->ciclo = $request->ciclo;
            $Entity->estado_estudiante = $request->estado_estudiante;

            if ($Entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function educacion_delete(Request $request)
    {
        $status = false;
        $message = null;
        $entity = Educacion::find($request->id);

        if ($entity->alumno_id == Auth::guard('alumnos')->user()->id) {
            if ($entity->delete()) $status = true;
        } else {
            $message = "No tiene privilegios, para realizar esta acción";
        }

        return response()->json(['Success' => $status, 'Message' => $message]);
    }

    public function experiencia_laboral($id)
    {
        $entity = null;
        $Anios = range(date('Y'), date('Y') - 30);

        if ($id != 0) {
            $entity = ExperienciaLaboral::find($id);
            if ($entity != null && $entity->alumno_id != Auth::guard('alumnos')->user()->id) {
                $entity = null;
            }
        }

        return view('app.alumno._experienciaLaboral', ['areas' => Area::all(), 'anios' => $Anios, 'Experiencia' => $entity]);
    }

    public function experiencias()
    {
        return response()->json(['data' => ExperienciaLaboral::with('areas')->where('alumno_id', Auth::guard('alumnos')->user()->id)->get()]);
    }

    public function experiencia_store(Request $request)
    {
        $status = false;

        if ($request->id != 0) {
            $Entity = ExperienciaLaboral::where('id', $request->id)->where('alumno_id', Auth::guard('alumnos')->user()->id)->first();
            if (!$Entity)
                return response()->json(['Success' => $status, 'Message' => 'Información no encontrada o borrada']);
        } else {
            $Entity = new ExperienciaLaboral();
        }

        $validator = Validator::make($request->all(), [
            'empresa' => 'required',
            'puesto' => 'required',
            // 'descripcion' => 'required',
        ]);

        if (!$validator->fails()) {

            $Entity->alumno_id = Auth::guard('alumnos')->user()->id;
            $Entity->empresa = $request->empresa;
            $Entity->puesto = $request->puesto;
            $Entity->area_id = $request->area_id;
            $Entity->personas_a_cargo = $request->personas_a_cargo;
            $Entity->desde_mes = $request->desde_mes;
            $Entity->desde_anio = $request->desde_anio;
            $Entity->hasta_mes = $request->hasta_mes;
            $Entity->hasta_anio = $request->hasta_anio;
            $Entity->sector = $request->sector;
            // $Entity->descripcion = $request->descripcion;
            $Entity->descripcion = $request->descrip;
            $Entity->estado = $request->estado;
            $Entity->inicio_laburo = $request->inicio_laburo;
            $Entity->fin_laburo = $request->fin_laburo;

            if ($Entity->save()) $status = true;
        }

        //return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
        return redirect()->route('alumno.perfil');
    }

    public function experiencia_delete(Request $request)
    {
        $status = false;
        $message = null;
        $entity = ExperienciaLaboral::find($request->id);

        if ($entity->alumno_id == Auth::guard('alumnos')->user()->id) {
            if ($entity->delete()) $status = true;
        } else {
            $message = "No tiene privilegios, para realizar esta acción";
        }

        return response()->json(['Success' => $status, 'Message' => $message]);
    }

    public function referencia_laboral($id)
    {
        $entity = null;
        if ($id != 0) {
            $entity = ReferenciaLaboral::find($id);
            if ($entity != null && $entity->alumno_id != Auth::guard('alumnos')->user()->id) {
                $entity = null;
            }
        }

        return view('app.alumno._referenciaLaboral', ['Referencia' => $entity]);
    }

    public function referencias()
    {
        return response()->json(['data' => ReferenciaLaboral::where('alumno_id', Auth::guard('alumnos')->user()->id)->get()]);
    }

    public function referencia_store(Request $request)
    {
        $status = false;

        if ($request->id != 0) {
            $Entity = ReferenciaLaboral::where('id', $request->id)->where('alumno_id', Auth::guard('alumnos')->user()->id)->first();
            if (!$Entity)
                return response()->json(['Success' => $status, 'Message' => 'Información no encontrada o borrada']);
        } else {
            $Entity = new ReferenciaLaboral();
        }

        $validator = Validator::make($request->all(), [
            'institucion' => 'required'
        ]);

        if (!$validator->fails()) {

            $Entity->alumno_id = Auth::guard('alumnos')->user()->id;
            $Entity->name_curso = $request->name_curso;
            $Entity->institucion = $request->institucion;
            $Entity->estado = $request->estado;
            $Entity->inicio_curso = $request->inicio_curso;
            $Entity->fin_curso = $request->fin_curso;

            if ($Entity->save()) $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function referencia_delete(Request $request)
    {
        $status = false;
        $message = null;
        $entity = ReferenciaLaboral::find($request->id);

        if ($entity->alumno_id == Auth::guard('alumnos')->user()->id) {
            if ($entity->delete()) $status = true;
        } else {
            $message = "No tiene privilegios, para realizar esta acción";
        }

        return response()->json(['Success' => $status, 'Message' => $message]);
    }

    public function habilidad()
    {
        $Habilidades = Habilidad::where('tipo', App::$HABILIDAD_PERSONAL)->get();

        $AlumnoHabilidad = AlumnoHabilidad::where('alumno_id', Auth::guard('alumnos')->user()->id)
            ->pluck('habilidad_id')->toArray();

        return view('app.alumno._habilidad', ['alumnoHabilidad' => $AlumnoHabilidad, 'habilidades' => $Habilidades, 'tipo' => App::$HABILIDAD_PERSONAL]);
    }

    public function habilidad_profesional()
    {
        $Habilidades = Habilidad::where('tipo', App::$HABILIDAD_PROFESIONAL)->get();

        $AlumnoHabilidad = AlumnoHabilidad::where('alumno_id', Auth::guard('alumnos')->user()->id)
            ->pluck('habilidad_id')->toArray();

        return view('app.alumno._habilidad', ['alumnoHabilidad' => $AlumnoHabilidad, 'habilidades' => $Habilidades, 'tipo' => App::$HABILIDAD_PROFESIONAL]);
    }

    public function habilidades()
    {
        return response()->json(['data' => AlumnoHabilidad::with('habilidades')->where('alumno_id', Auth::guard('alumnos')->user()->id)->get()]);
    }

    public function habilidad_store(Request $request)
    {
        $status = false;

        $validator = Validator::make($request->all(), [
            'habilidades' => 'required'
        ]);

        if (!$validator->fails()) {

            AlumnoHabilidad::where('alumno_id', Auth::guard('alumnos')->user()->id)
                ->whereHas('habilidades', function ($query) use ($request) {
                    $query->where('tipo',  $request->tipo);
                })->delete();

            foreach ($request->habilidades as $q) {
                $Entity = new AlumnoHabilidad();
                $Entity->alumno_id = Auth::guard('alumnos')->user()->id;
                $Entity->habilidad_id = $q;
                $Entity->save();
            }

            $status = true;
        }

        return response()->json(['Success' => $status, 'Errors' => $validator->errors()]);
    }

    public function perfil_validacion()
    {
        $errors = Alumno::ValidatePerfilAlumno();
        return response()->json(['Errors' => count($errors)]);
    }
}
