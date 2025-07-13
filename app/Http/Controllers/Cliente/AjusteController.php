<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ClienteConfig;
use App\Interfaces\UploadServiceInterface;
use DNS2D;

class AjusteController extends Controller
{
    public function ajustes($id){
        $cliente = Cliente::with('config')->select('id', 'nombre')->findOrFail($id);
        return [
            'id' => $cliente->id,
            'nombre' => $cliente->nombre,
            'logo_url' => $cliente->config->logo_url ?? null,
            'portada_url' => $cliente->config->portada_url ?? null,
        ];
    }

    public function storeLogo(Request $request, UploadServiceInterface $uploadService)
    {
        $config = ClienteConfig::where('cliente_id', $request->ClienteId)->first();
  
        $imageName = $uploadService->uploadFile($request->Logo, 'public/negocio');
        $config->logo_url = $imageName;
        $config->save();
        return $this->message('success', 'Guardado!', $config);
    }

    public function storePortada(Request $request, UploadServiceInterface $uploadService)
    {
        $config = ClienteConfig::where('cliente_id', $request->ClienteId)->first();
  
        $imageName = $uploadService->uploadFile($request->Portada, 'public/negocio');
        $config->portada_url = $imageName;
        $config->save();
        return $this->message('success', 'Guardado!', $config);
    }

    public function storeNombre(Request $request)
    {
        $cliente = Cliente::findOrFail($request->ClienteId);
        $cliente->nombre = $request->Nombre;
        $cliente->save();
        return $this->message('success', 'Guardado!', $cliente);
    }

    public function viewQr($id)
    {
        $cliente = Cliente::findOrFail($id);
        $urlBase = config('app.frontend_url');
        $url = "{$urlBase}menu/{$cliente->id}";

        $qrCode = base64_decode(DNS2D::getBarcodePNG($url, 'QRCODE', 5, 5));

        return response($qrCode)
            ->header('Content-Type', 'image/png');
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
