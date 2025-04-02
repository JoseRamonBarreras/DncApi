<?php 
namespace App\Services\Matriz;
use DB;
use stdClass;

class InstructorService
{
	static function instructores($request){
		$response = new stdClass();
		$response->Instructores = self::getInstructores($request);
        $response->Total = $response->Instructores->sum('CostoTotal');
		return $response;
	}

    private static function getInstructores($request){
        $instructores = self::getInstructoresQuery($request);

        return $instructores->map(function ($instructor) {
            $instructor->Cursos = self::getCursos($instructor->Instructor);
            $instructor->CostoTotal = $instructor->Cursos->sum('CostoEstimado');
            return $instructor;
        });
    }

    private static function getInstructoresQuery($request){
        $where = '';
        if ($request->Filtro != 0) { $where = ' where i.Instructor = ' . $request->Filtro; }

        $instructores = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT DISTINCT i.Instructor, i.RFC, i.Nombre, i.CostoEstimado 
                FROM CapInstructores as i
                JOIN CapCursos as c ON c.Instructor = i.Instructor 
                JOIN CapMatrizCursoEmpresa as me ON c.Curso = me.Curso
                JOIN CapMatrizCursoPuesto as mp ON c.Curso = mp.Curso 
                $where
            ")
        );
        return collect($instructores);
    }

    private static function getCursos($instructor){
        $cursos = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT mp.Curso, c.Clave, c.Nombre, i.Nombre as NombreInstructor, c.Importancia, SUM(i.CostoEstimado) as CostoEstimado 
                FROM CapMatrizCursoPuesto as mp
                JOIN CapCursos as c ON mp.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN CapMatrizCursoEmpresa as me ON c.Curso = me.Curso
                where i.Instructor = $instructor
                GROUP BY mp.Curso, c.Clave, c.Nombre, i.Nombre, c.Importancia
                ORDER by mp.Curso 
            ")
        );
        return collect($cursos);
    }

    static function instructoresExcel($request){
        $where = '';
        if ($request->Filtro != 0) { $where = ' where i.Instructor = ' . $request->Filtro; }
        $instructores = DB::connection('Capacitaciones')->select(
            DB::raw("
                SELECT i.Instructor, i.RFC, i.Nombre as NombreInstructor, c.Clave, c.Nombre, c.Importancia, i.CostoEstimado as Costo 
                FROM CapMatrizCursoPuesto as mp
                JOIN CapCursos as c ON mp.Curso = c.Curso 
                JOIN CapInstructores as i ON c.Instructor = i.Instructor 
                JOIN CapMatrizCursoEmpresa as me ON c.Curso = me.Curso
                $where
                ORDER by c.Importancia 
            ")
        );
        return collect($instructores);
    }

}