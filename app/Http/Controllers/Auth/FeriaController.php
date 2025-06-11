<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use Carbon\Carbon;
use BolsaTrabajo\Area;
use BolsaTrabajo\Feria;
use BolsaTrabajo\Alumno;
use BolsaTrabajo\Distrito;
use BolsaTrabajo\Educacion;
use BolsaTrabajo\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use BolsaTrabajo\ReferenciaLaboral;
use BolsaTrabajo\ExperienciaLaboral;
use BolsaTrabajo\HistorialCitas;
use Illuminate\Support\Facades\Auth;
use BolsaTrabajo\Http\Controllers\Controller;
use PDF;
use Illuminate\Support\Str;

class FeriaController extends Controller
{
    public function index()
    {
        return view('auth.feria.index');
    }
    public function agregarFeria()
    {
        return view('auth.feria.add-feria');
    }
    public function storeAgregarFeria(Request $request)
    {
        try {
            $nombreOriginal = $request->name;
            $slug  = Str::slug(str_replace('ñ', 'n', $nombreOriginal));
            $slugExistente = Feria::where('route', $slug)->exists();
            if ($slugExistente) {
                return redirect()->back()->withInput()->with('error', 'Ya existe una feria con este nombre o ruta. Por favor, elige otro nombre.');
            }
            DB::beginTransaction();
            $feriaNew = new Feria();
            $feriaNew->name = $request->name;
            $feriaNew->fecha_inicio = $request->startDate;
            $feriaNew->fecha_final = $request->endDate;
            $feriaNew->route = $slug;
            $feriaNew->created_at = Carbon::now();
            $feriaNew->save();
            DB::commit();
            return redirect()->route('auth.feria')->with('success', '¡La feria fue registrada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al registrar la feria. ' . $e->getMessage());
        }
    }
    public function filtrar(Request $request)
    {
        try {
            $start = Carbon::parse($request->startDate)->startOfDay();
            $end = Carbon::parse($request->endDate)->endOfDay();
            $ferias = Feria::whereBetween('fecha_inicio', [$start, $end])
                ->where('state', 1)->whereNull('deleted_at')
                ->get(['id', 'name', 'fecha_inicio', 'fecha_final', 'route']);
            return response()->json($ferias);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al filtrar ferias'], 500);
        }
    }
    public function edit($id)
    {
        $feriaData = Feria::where('id', $id)->whereNull('deleted_at')->first();
        if ($feriaData) {
            return view('auth.feria.edit-feria')->with('feriaData', $feriaData);
        } else {
            return redirect()->route('auth.feria');
        }
    }
    public function storeEditarFeria(Request $request)
    {
        try {
            DB::beginTransaction();
            $feria = Feria::find($request->idFeria);
            if (!$feria) {
                return redirect()->back()->with('error', 'La feria no existe.');
            }
            $feria->update([
                'name' => $request->name,
                'fecha_inicio' => $request->startDate,
                'fecha_final' => $request->endDate,
                'updated_at' => Carbon::now(),
            ]);
            DB::commit();
            return redirect()->route('auth.feria')->with('success', '¡La feria fue editada correctamente!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al editar la feria: ' . $e->getMessage());
        }
    }
    public function deleteFeria($id)
    {
        try {
            $userLogin = Auth::user();
            $feria = Feria::find($id);
            if (!$feria) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'La feria no existe.'], 404);
                }
                return redirect()->route('auth.feria')->with('error', 'La feria no existe.');
            }
            $feria->update([
                'deleted_modified_by' => $userLogin->id,
                'deleted_at' => Carbon::now(),
            ]);
            if (request()->ajax()) {
                return response()->json(['success' => '¡La feria fue eliminada correctamente!']);
            }
            return redirect()->route('auth.feria')->with('success', '¡La feria fue eliminada correctamente!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Error al eliminar la feria.'], 500);
            }
            return redirect()->route('auth.feria')->with('error', 'Error al eliminar la feria.');
        }
    }
    public function listadaEmpresa($id)
    {
        $avisoEmpresaFeriaData = DB::table('aviso_empresa_feria as a')
            ->join('empresas as e', 'a.ruc_empresa', '=', 'e.ruc')
            ->where('a.id_feria', $id)
            ->whereNull('a.deleted_at')
            ->select(
                'a.ruc_empresa as rucEmpresa',
                'e.nombre_comercial as nameEmpresa',
                'e.razon_social as razonEmpresa',
                DB::raw('COUNT(a.id) as totalAvisos'),
                DB::raw("GROUP_CONCAT(a.id SEPARATOR '-') as idsAvisos")
            )
            ->groupBy('a.ruc_empresa', 'e.nombre_comercial', 'e.razon_social')
            ->get();
        return view('auth.feria.lista-aviso-feria')->with('avisoEmpresaFeriaData', $avisoEmpresaFeriaData);
    }
    public function listadaEmpresaPostulantes($id)
    {
        $ids = explode('-', $id);
        $grupoData = DB::table('postulacion_alumno_aviso_feria as p')
            ->join('aviso_empresa_feria as a', 'p.id_aviso_feria', '=', 'a.id')
            ->whereIn('p.id_aviso_feria', $ids)
            ->whereNull('p.deleted_at')
            ->where('p.state', 1)
            ->select(
                'a.name as nombreAviso',
                DB::raw('COUNT(p.id) as totalPostulantes')
            )
            ->groupBy('a.name')
            ->get();
        $postulantesData = DB::table('postulacion_alumno_aviso_feria as p')
            ->join('alumnos as a', 'p.dni_alumno', '=', 'a.dni')
            ->join('aviso_empresa_feria as av', 'p.id_aviso_feria', '=', 'av.id')
            ->whereIn('p.id_aviso_feria', $ids)
            ->whereNull('p.deleted_at')
            ->where('p.state', 1)
            ->select('a.nombres as nameAlumno', 'a.apellidos as lastNameAlumno', 'a.email as emailAlumno', 'a.telefono as phoneAlumno', 'a.id as idAlumno', 'av.name as nameAviso')
            ->get();
        return view('auth.feria.lista-postulante-aviso-feria')->with('grupoData', $grupoData)->with('postulantesData', $postulantesData);
    }
    public function verCvEmpresaPostulante($id)
    {
        $Alumno = Alumno::where('id', $id)->first();
        $Areas = Area::all();
        $Provincias = Provincia::all();
        $distritoData  = Distrito::where('id', $Alumno->distrito_id)->first();
        $Educaciones = Educacion::where('alumno_id', $id)->orderBy('estudio_inicio', 'DESC')->get();
        $ExperienciaLaboral = ExperienciaLaboral::where('alumno_id', $id)->orderBy('inicio_laburo', 'DESC')->get();
        $Educaciones = Educacion::where('alumno_id', $id)->orderBy('estudio_inicio', 'DESC')->get();
        $ReferenciaLaboral = ReferenciaLaboral::where('alumno_id', $Alumno->id)->orderBy('inicio_curso', 'DESC')->get();
        $pdf = PDF::loadView('app.avisos.cv_postulado',  ['referenciaLaboral' => $ReferenciaLaboral, 'provincias' => $Provincias, 'areas' => $Areas, 'alumno' => $Alumno, "experienciaLaboral" => $ExperienciaLaboral, "educaciones" => $Educaciones, 'distritoAlumno' => $distritoData->nombre]);
        return $pdf->stream();
    }
    public function listaCitasAsesora()
    {
        return view('auth.feria.asesora.lista-citas-asesora');
    }
    public function filtrarCitasAsesoras(Request $request)
    {
        try {
            $start = $request->startDate;
            $end = $request->endDate;
            $citas = DB::table('historial_citas')
                ->join('alumnos', 'historial_citas.dni', '=', 'alumnos.dni')
                ->join('asesoras_express', 'historial_citas.id_asesora', '=', 'asesoras_express.id')
                ->whereBetween('historial_citas.dia', [$start, $end])
                ->whereNull('historial_citas.deleted_at')
                ->select(
                    'historial_citas.id',
                    'historial_citas.dia',
                    'historial_citas.hora',
                    'historial_citas.motivo',
                    'historial_citas.phone',
                    'historial_citas.state',
                    'historial_citas.updated_at',
                    'alumnos.nombres as nombre_alumno',
                    'alumnos.apellidos as apellido_alumno',
                    'asesoras_express.name as nombre_asesora'
                )
                ->get();
            // Procesar estado
            $citas = $citas->map(function ($cita) {
                if ($cita->state == 1) {
                    $cita->estado_cita = "Falta atender";
                } elseif ($cita->state == 0) {
                    $fechaAtencion = Carbon::parse($cita->updated_at)->format('Y-m-d H:i');
                    $cita->estado_cita = "Fue atendido el día: " . $fechaAtencion;
                } else {
                    $cita->estado_cita = "Estado desconocido";
                }
                return $cita;
            });
            return response()->json($citas);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al filtrar citas: ' . $e], 500);
        }
    }
    public function finalizarCitasAsesora($id)
    {
        try {
            $userLogin = Auth::user();
            $cita = HistorialCitas::find($id);
            if (!$cita) {
                if (request()->ajax()) {
                    return response()->json(['error' => 'La cita no existe.'], 404);
                }
                return redirect()->route('auth.ferias.finalizar-citas-asesora')->with('error', 'La cita no existe.');
            }
            $cita->update([
                'state' => 0,
                'updated_at' => Carbon::now(),
            ]);
            if (request()->ajax()) {
                return response()->json(['success' => '¡La cita fue actualizado correctamente!']);
            }
            return redirect()->route('auth.ferias.finalizar-ferias-asesora')->with('success', '¡La cita fue actualizado correctamente!');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Error al actualizar la cita. ' . $e], 500);
            }
            return redirect()->route('auth.feria')->with('error', 'Error al eliminar la feria.');
        }
    }
}
