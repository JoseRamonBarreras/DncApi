<?php 
namespace App\Services\Matriz;
use DB;
use stdClass;

class CursoService
{
	static function cursos($request){
		$response = new stdClass();
		$response->Obligatorios = self::getCursos($request, 'OBLIGATORIO');
        $response->TotalObligatorios = $response->Obligatorios->sum('Total');
		$response->Opcionales = self::getCursos($request, 'OPCIONAL');
        $response->TotalOpcionales = $response->Opcionales->sum('Total');
		return $response;
	}

	private static function getCursos($request, $importancia){
		$cursos = ($request->Filtro == 0) ? self::getAllCursos($importancia) : self::getPorCurso($request, $importancia);

        return $cursos->map(function ($curso) {
            $curso->Empresas = self::getEmpresas($curso->Curso);
            $curso->Total = $curso->Empresas->sum('Costo');
            return $curso;
        });
	}

	private static function getAllCursos($importancia){
        $cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT c.Curso, c.Clave, c.Nombre, c.Importancia, c.Instructor, i.Nombre as NombreInstructor, i.CostoEstimado 
                FROM CapCursos as c
                INNER JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                WHERE c.Importancia = '$importancia'
                order by c.Importancia, c.Clave 
            ")
        );
        return collect($cursos);
    }

    private static function getPorCurso($request, $importancia){
    	$cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT c.Curso, c.Clave, c.Nombre, c.Importancia, c.Instructor, i.Nombre as NombreInstructor, i.CostoEstimado 
                FROM CapCursos as c
                INNER JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                WHERE c.Curso = $request->Filtro and c.Importancia = '$importancia'
                order by c.Importancia 
            ")
        );
        return collect($cursos);
    }

    private static function getEmpresas($cursoId){
        $empresas = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT e.Empresa, e.NombreCorto, SUM(i.CostoEstimado) as Costo 
                FROM CapMatrizCursoPuesto as m
                JOIN CapCursos as c ON m.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN NomEmpresas as e ON m.Empresa = e.Empresa 
                where m.Curso = $cursoId
                GROUP BY e.Empresa, e.NombreCorto
                order by e.Empresa
            ")
        );
        return collect($empresas);
    }

    static function cursosExcel($request){
        $where = '';
        if ($request->Filtro != 0) { $where = ' where c.Curso = ' . $request->Filtro; }
        $cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT c.Clave, c.Nombre, c.Importancia, i.Nombre as Instructor, e.NombreCorto as Empresa, i.CostoEstimado as Costo 
                FROM CapMatrizCursoPuesto as m
                JOIN CapCursos as c ON m.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN NomEmpresas as e ON m.Empresa = e.Empresa
                $where
                order by c.Importancia, c.Clave  
            ")
        );
        return collect($cursos);
    }
}