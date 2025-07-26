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

    //Horarios
    public function horarios($id){
        $cliente = Cliente::with('horarios')->select('id', 'nombre')->findOrFail($id);
        return $cliente;
    }

    public function storeHorario(Request $request)
    {
        $clienteId = $request->input('ClienteId');
        $horarios = $request->input('horarios');

        foreach ($horarios as $h) {
            $horario = ClienteHorario::where('cliente_id', $clienteId)
                            ->where('dia_semana', $h['dia'])
                            ->first();

            if ($horario) {
                $horario->abre_desde = $h['horaInicio'];
                $horario->cierra_hasta = $h['horaFin'];
                $horario->activo = $h['activo'];
                $horario->save();
            }
        }

        return response()->json([
            'message' => 'Horarios actualizados correctamente'
        ], 200);
    }

    //Horarios
    public function envios($id){
        $cliente = Cliente::with('envioConfig.rangos', 'envioConfig.tipoEnvio')->select('id', 'nombre')->findOrFail($id);
        return $cliente;
    }

    public function storeEnvio(Request $request)
    {
        $config = ClienteEnvioConfig::where('cliente_id', $request->ClienteId)->first();

        if ($request->envio['EntregaDomicilio']) {
           $config->tipo_envio_id = $request->envio['TipoCosto'];
           if ($request->envio['TipoCosto'] == 1) {
               $config->precio_fijo = $request->envio['PrecioFijo'];
           }
        }
        $config->permite_entrega_domicilio = $request->envio['EntregaDomicilio'];
        $config->permite_recoger_sucursal = $request->envio['RecogerSucursal'];
        $config->save();
        return $this->message('success', 'Guardado!', $config);
    }

    public function storeRangos(Request $request)
    {
        $envioId = $request->input('EnvioId');
        $nuevosRangos = $request->input('rangos.rangos');

        DB::beginTransaction();
        try {
            $rangosActuales = EnvioRango::where('clientes_envio_config_id', $envioId)->get();

            $rangosClave = collect($nuevosRangos)->map(function ($r) {
                return $r['km_min'] . '-' . $r['km_max'];
            })->toArray();

            foreach ($rangosActuales as $rangoExistente) {
                $clave = $rangoExistente->km_min . '-' . $rangoExistente->km_max;

                if (!in_array($clave, $rangosClave)) {
                    $rangoExistente->delete();
                }
            }

            foreach ($nuevosRangos as $rango) {
                EnvioRango::updateOrCreate(
                    [
                        'clientes_envio_config_id' => $envioId,
                        'km_min' => $rango['km_min'],
                        'km_max' => $rango['km_max'],
                    ],
                    [
                        'precio' => $rango['precio'],
                    ]
                );
            }

            DB::commit();
            return response()->json(['message' => 'Rangos actualizados correctamente.']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al guardar rangos', 'error' => $e->getMessage()], 500);
        }
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
