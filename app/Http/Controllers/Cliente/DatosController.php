<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ClienteConfig;
use App\Models\ClienteHorario;
use App\Models\ClienteEnvioConfig;
use App\Models\EnvioRango;
use DB;

class DatosController extends Controller
{
    public function datos($id){
        $cliente = Cliente::with('config')->select('id', 'nombre')->findOrFail($id);
        return [
            'id' => $cliente->id,
            'direccion' => $cliente->config->direccion ?? null,
            'ubicacion_lat' => (float) $cliente->config->ubicacion_lat ?? null,
            'ubicacion_lng' => (float) $cliente->config->ubicacion_lng ?? null,
            'whatsapp' => $cliente->config->whatsapp ?? null,
        ];
    }

    public function storeDireccion(Request $request)
    {
        $config = ClienteConfig::where('cliente_id', $request->id)->first();
        $config->direccion = $request->direccion;
        $config->ubicacion_lat = $request->ubicacion_lat;
        $config->ubicacion_lng = $request->ubicacion_lng;
        $config->save();
        return $this->message('success', 'Guardado!', $config);
    }

    public function storeWhatsapp(Request $request)
    {
        $config = ClienteConfig::where('cliente_id', $request->id)->first();
        $config->whatsapp = $request->whatsapp;
        $config->save();
        return $this->message('success', 'Guardado!', $config);
    }

    private function message($type, $title, $object ){
        return response()->json(
            [
                "type" => $type,
                "title" => $title,
                "object" => $object
            ]
        );
    }
}
