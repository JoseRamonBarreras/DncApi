<?php 
namespace App\Services;
use App\Interfaces\ReporteMatriz;
use App\Services\Matriz\CursoService;
use App\Services\Matriz\EmpresaService;
use App\Services\Matriz\PuestoService;
use App\Services\Matriz\InstructorService;

class ReporteMatrizService implements ReporteMatriz
{
	public function getReporte($request){
		if ($request->Tipo == 'Empresa') {
			return $this->getEmpresas($request);
		}
		if ($request->Tipo == 'Puesto') {
			return $this->getPuestos($request);
		}
		if ($request->Tipo == 'Instructor') {
			return $this->getInstructores($request);
		}
		return $this->getCursos($request);
	}

	private function getCursos($request){
		if ($request->Formato == 'PDF') {
			return CursoService::cursos($request);
		}
		return CursoService::cursosExcel($request);
	}

	private function getEmpresas($request){
		if ($request->Formato == 'PDF') {
			return EmpresaService::empresas($request);
		}
		return EmpresaService::empresasExcel($request);
	}

	private function getPuestos($request){
		if ($request->Formato == 'PDF') {
			return PuestoService::puestos($request);
		}
		return PuestoService::puestosExcel($request);
	}

	private function getInstructores($request){
		if ($request->Formato == 'PDF') {
			return InstructorService::instructores($request);
		}
		return InstructorService::instructoresExcel($request);
	}

}