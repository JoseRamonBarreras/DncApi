<?php 
namespace App\Services;
use App\Interfaces\ImprimirRequisicion;
use App\Models\Cia;
use App\Models\Requisicion;
use stdClass;

class ImprimirRequisicionService implements ImprimirRequisicion
{
	public function getReporte($request){
		return $this->getConcentrado($request);
	}

	private function getConcentrado($request){
		$respuesta = $this->getHeader($request);
		$respuesta->Requisicion = Requisicion::requisicion($request->Requisicion);
		$respuesta->Movimientos = Requisicion::movimientos($respuesta->Requisicion);
		return response()->json( $respuesta );
	}

	private function getHeader($request){
    	$response = new stdClass();
    	$response->Cia = Cia::select('Nombre')->first()->Nombre;
    	return $response;
    }
}