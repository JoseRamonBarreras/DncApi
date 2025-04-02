<?php 
namespace App\Services\Matriz;
use DB;
use stdClass;

class EmpresaService
{
	static function empresas($request){
		$response = new stdClass();
		$response->Empresas = self::getEmpresas($request);
        $response->Total = $response->Empresas->sum('CostoTotal');
		return $response;
	}

	private static function getEmpresas($request){
		$empresas = ($request->Filtro == 0) ? self::getAllEmpresas() : self::getPorEmpresa($request);

        return $empresas->map(function ($empresa) {
            $empresa->Cursos = self::getCursos($empresa->Empresa);
            $empresa->CostoTotal = $empresa->Cursos->sum('CostoEstimado');
            return $empresa;
        });
	}

	private static function getAllEmpresas(){
        $empresas = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT DISTINCT m.Empresa, e.NombreCorto
                FROM CapMatrizCursoPuesto as m
                JOIN NomEmpresas as e ON m.Empresa = e.Empresa 
                order by m.Empresa 
            ")
        );
        return collect($empresas);
    }

    private static function getPorEmpresa($request){
    	$empresas = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT DISTINCT m.Empresa, e.NombreCorto
                FROM CapMatrizCursoPuesto as m
                JOIN NomEmpresas as e ON m.Empresa = e.Empresa 
                where m.Empresa = $request->Filtro
                order by m.Empresa 
            ")
        );
        return collect($empresas);
    }

    private static function getCursos($empresa){
        $cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT c.Clave, c.Nombre, i.Nombre as NombreInstructor, SUM(i.CostoEstimado) as CostoEstimado, c.Importancia  
                FROM CapMatrizCursoPuesto as m
                JOIN CapCursos as c ON m.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                where m.Empresa = $empresa
                GROUP BY c.Clave, c.Nombre, i.Nombre, c.Importancia
                order by c.Clave, c.Importancia  
            ")
        );
        return collect($cursos);
    }

    static function empresasExcel($request){
        $where = '';
        if ($request->Filtro != 0) { $where = ' where m.Empresa = ' . $request->Filtro; }
        $empresas = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT e.NombreCorto as Empresa, c.Clave, c.Nombre, i.Nombre as NombreInstructor, c.Importancia, i.CostoEstimado as Costo 
                FROM CapMatrizCursoPuesto as m
                JOIN CapCursos as c ON m.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN NomEmpresas as e ON m.Empresa = e.Empresa  
                $where
                order by m.Empresa
            ")
        );
        return collect($empresas);
    }
}