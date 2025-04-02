<?php 
namespace App\Helpers;
use App\Models\Cia;
use App\Models\User;

class Connection 
{
	static function getConnection($request){
		$header = apache_request_headers();
        $user = User::find( $header['user_id'] );
        $cia = Cia::where('id', $user->cia_id)->first();
        return $cia->conexion_salud; 
	}

	static function getNumeroEmpresa($request){
		$header = apache_request_headers();
        $user = User::find( $header['user_id'] );
        return $user->cia_id; 
	}

	static function getConnectionUserId($userId){
        $user = User::find( $userId );
        $cia = Cia::where('id', $user->cia_id)->first();
        return $cia->conexion; 
	}

	static function getConnectionCia($ciaId){
		$cia = Cia::where('id', $ciaId)->first();
        return $cia->conexion; 
	}
}