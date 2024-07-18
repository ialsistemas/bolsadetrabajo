<?php

namespace BolsaTrabajo\Http\Controllers\Auth;

use BolsaTrabajo\Inicio;
use BolsaTrabajo\Anuncio;
use BolsaTrabajo\Cargo;
use BolsaTrabajo\Condicion;
use Illuminate\Http\Request;
use BolsaTrabajo\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use BolsaTrabajo\Empresa;
use BolsaTrabajo\Programa;
use BolsaTrabajo\Alumno;
use Illuminate\Support\Facades\DB;

class InicioController extends Controller
{
    public function index(Request $request)
    {
        // Obtener fechas desde la solicitud
        $fechaDesde = $request->input('fecha_desde', "2000-01-01");
        $fechaHasta = $request->input('fecha_hasta', date('Y-m-d'));

        // Obtener datos filtrados por fechas
        $empresas = $this->getEmpresasPorTipoPersona($fechaDesde, $fechaHasta);
        $programasContratados = $this->getProgramasContratados($fechaDesde, $fechaHasta);
        $totalEmpresasAprobadas = $this->getTotalEmpresasAprobadas($fechaDesde, $fechaHasta);
        $totalUsuarios = $this->getTotalUsuarios($fechaDesde, $fechaHasta);
        $totalAvisos = $this->getTotalAvisos($fechaDesde, $fechaHasta);
        $totalAvisosporEmpleador = $this->getTotalAvisosporEmpleador($fechaDesde, $fechaHasta);
        $totalContratadosporCarrera = $this->getTotalContratadosporCarrera($fechaDesde, $fechaHasta);
        $TotalUsuariosporCarrera = $this->getTotalUsuariosporCarrera($fechaDesde, $fechaHasta);


        // Pasar los datos a la vista 'auth.inicio.index'
        return view('auth.inicio.index', compact('TotalUsuariosporCarrera', 
        'totalContratadosporCarrera', 'totalAvisosporEmpleador', 'totalAvisos', 
        'totalUsuarios', 'totalEmpresasAprobadas', 'empresas', 'programasContratados', 
        'fechaDesde', 'fechaHasta'));
    }
    
    // Métodos privados con filtro por fecha
    private function getEmpresasPorTipoPersona($fecha_desde, $fecha_hasta)
    {
        return DB::table('empresas as e')
            ->join('tipo_personas as tp', 'e.tipo_persona', '=', 'tp.id')
            ->whereBetween('e.created_at', [$fecha_desde, $fecha_hasta])
            ->selectRaw('tp.tipo as tipo_persona, COUNT(*) as cantidad')
            ->groupBy('e.tipo_persona', 'tp.tipo')
            ->get();
    }



    private function getProgramasContratados($fecha_desde, $fecha_hasta)
    {
        // Utilizamos Query Builder para la consulta
        $programasContratados = DB::table('programas')
            ->select('tipo_programa', DB::raw('SUM(contratados) as cantidad'))
            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
            ->groupBy('tipo_programa')
            ->get();

        return $programasContratados;
    }

    private function getTotalEmpresasAprobadas($fecha_desde, $fecha_hasta)
    {
        return DB::table('empresas')
            ->where('aprobado', '1')
            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
            ->count();
    }

    private function getTotalUsuarios($fecha_desde, $fecha_hasta)
    {
        return DB::table('alumnos')
            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
            ->count();
    }

    private function getTotalAvisos($fecha_desde, $fecha_hasta)
    {
        return DB::table('avisos')
            ->whereBetween('created_at', [$fecha_desde, $fecha_hasta])
            ->count();
    }

    public function getTotalAvisosporEmpleador($fecha_desde, $fecha_hasta)
 {
    $results = DB::table('empresas as e')
        ->join('tipo_personas as t', 't.id', '=', 'e.tipo_persona')
        ->join('avisos as a', 'e.id', '=', 'a.empresa_id')
        ->whereBetween('a.created_at', [$fecha_desde, $fecha_hasta])
        ->select('t.tipo as tipo_persona', DB::raw('COUNT(*) as total'))
        ->groupBy('t.tipo')
        ->get();

    // Preparar los datos para Highcharts
    $series = [];
    foreach ($results as $dato) {
        $serie = [
            'name' => $dato->tipo_persona,
            'y' => $dato->total,
        ];
        $series[] = $serie;
    }

    // Retornar los datos en formato JSON
    return $series;
}


    public function getTotalContratadosporCarrera($fecha_desde, $fecha_hasta)
    {
        $datos = DB::table('alumno_avisos AS aa')
            ->join('alumnos AS a', 'aa.alumno_id', '=', 'a.id')
            ->join('estados AS e', 'aa.estado_id', '=', 'e.id')
            ->leftJoin('areas AS ar', 'a.area_id', '=', 'ar.id')
            ->where('e.nombre', '=', 'CONTRATADO')
            ->whereBetween('aa.created_at', [$fecha_desde, $fecha_hasta])
            ->groupBy('ar.nombre')
            ->select('ar.nombre AS nombre_area', DB::raw('COUNT(*) AS total_contratados'))
            ->get();

        $series = [];
        foreach ($datos as $dato) {
            $serie = [
                'name' => $dato->nombre_area,
                'y' => $dato->total_contratados,
                'drilldown' => $dato->nombre_area, // Puedes ajustar esto según tu necesidad
            ];
            $series[] = $serie;
        }

        return $series;
    }

    public function getTotalUsuariosporCarrera($fecha_desde, $fecha_hasta)
    {
        $resultados = DB::table('alumnos')
            ->select('alumnos.area_id', 'areas.nombre AS nombre_area', DB::raw('COUNT(alumnos.id) AS cantidad_alumnos'))
            ->join('areas', 'alumnos.area_id', '=', 'areas.id')
            ->whereBetween('alumnos.created_at', [$fecha_desde, $fecha_hasta])
            ->groupBy('alumnos.area_id', 'areas.nombre')
            ->orderBy('alumnos.area_id')
            ->get();

        return $resultados;
    }
}