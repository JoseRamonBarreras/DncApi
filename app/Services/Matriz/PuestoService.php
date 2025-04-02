<?php 
namespace App\Services\Matriz;
use DB;
use stdClass;

class PuestoService
{
	static function puestos($request){
		$response = new stdClass();
		$response->Puestos = self::getPuestos($request);
        $response->Total = $response->Puestos->sum('CostoTotal');
		return $response;
	}

    private static function getPuestos($request){
        $puestos = self::getPuestosQuery($request);

        return $puestos->map(function ($puesto) {
            $puesto->Cursos = self::getCursos($puesto->Puesto);
            $puesto->CostoTotal = $puesto->Cursos->sum('CostoEstimado');
            return $puesto;
        });
    }

    private static function getPuestosQuery($request){
        $wherePuesto = '';
        if ($request->Filtro != 0) { $wherePuesto = ' where m.Puesto = ' . $request->Filtro; }

        $puestos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT DISTINCT m.Puesto, p.Nombre 
                FROM CapMatrizCursoPuesto as m
                left JOIN NomPuestos as p ON m.Puesto = p.Puesto 
                $wherePuesto
            ")
        );
        return collect($puestos);
    }

    private static function getCursos($puesto){
        $cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT mp.Curso, c.Clave, c.Nombre, i.Nombre as NombreInstructor, c.Importancia, SUM(i.CostoEstimado) as CostoEstimado 
                FROM CapMatrizCursoPuesto as mp
                JOIN CapCursos as c ON mp.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN CapMatrizCursoEmpresa as me ON c.Curso = me.Curso
                JOIN NomEmpresas as e ON me.Empresa = e.Empresa 
                where mp.Puesto = $puesto
                GROUP BY mp.Curso, c.Clave, c.Nombre, i.Nombre, c.Importancia
                ORDER by mp.Curso 
            ")
        );
        return collect($cursos);
    }

    static function puestosExcel($request){
        $where = '';
        if ($request->Filtro != 0) { $where = ' where mp.Puesto = ' . $request->Filtro; }
        $puestos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT mp.Puesto, p.Nombre, mp.Curso, c.Clave, c.Nombre, i.Nombre as NombreInstructor, c.Importancia, i.CostoEstimado as Costo
                FROM CapMatrizCursoPuesto as mp
                JOIN NomPuestos as p ON mp.Puesto = p.Puesto 
                JOIN CapCursos as c ON mp.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN CapMatrizCursoEmpresa as me ON c.Curso = me.Curso
                JOIN NomEmpresas as e ON me.Empresa = e.Empresa 
                $where
                ORDER by mp.Puesto 
            ")
        );
        return collect($puestos);
    }

}