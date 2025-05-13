<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Especie;
use App\Interfaces\UploadServiceInterface;
use DNS2D;

class MascotaController extends Controller
{

    public function index()
    {
        $rol = request()->header('role');
        $id = request()->header('user_id');
        return Mascota::with('especie')->where('user_id', $id)->select('id', 'name', 'descripcion', 'birthday', 'phone', 'especie_id', 'foto')->get();
    }

    public function especies()
    {
        return Especie::all();
    }


    public function store(Request $request, UploadServiceInterface $uploadService)
    {
        $mascota = new Mascota();
        $mascota->name = $request->name;
        $mascota->descripcion = $request->descripcion;
        $mascota->birthday = $request->birthday;
        $mascota->especie_id = $request->especie_id;
        $mascota->user_id = $request->user_id;
        $mascota->phone = $request->phone;

        if ($request->filled('foto')) {
            $imageName = $uploadService->uploadFile($request->foto, 'public/mascotas');
            $mascota->foto = $imageName;
        }

        $mascota->save();
        return $this->message('success', 'Guardado!', $mascota);
    }


    public function show($id)
    {
        $mascota = Mascota::with(['especie']) 
                        ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Perfil de mascota',
            'mascota' => $mascota
        ]);
    }


    public function update(Request $request, $id, UploadServiceInterface $uploadService)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->name = $request->name;
        $mascota->descripcion = $request->descripcion;
        $mascota->birthday = $request->birthday;
        $mascota->especie_id = $request->especie_id;
        $mascota->user_id = $request->user_id;
        $mascota->phone = $request->phone;

        if ($request->has('foto') && $request->filled('foto')) {
            if ($mascota->foto) {
                $this->deleteOldImage($mascota->foto);
            }
            $imageName = $uploadService->uploadFile($request->foto, 'public/mascotas');
            $mascota->foto = $imageName;
        }

        $mascota->save();
        return $this->message('success', 'Actualizado!', $mascota);
    }

    private function deleteOldImage($imageName)
    {
        $imagePath = storage_path('app/public/mascotas/' . $imageName);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function viewQr($id)
    {
        $mascota = Mascota::findOrFail($id);
        $urlBase = config('app.frontend_url');
        $url = "{$urlBase}mascota/perfil/{$mascota->id}";

        $qrCode = base64_decode(DNS2D::getBarcodePNG($url, 'QRCODE', 5, 5));

        return response($qrCode)
            ->header('Content-Type', 'image/png');
    }

    public function descargarQr($id)
    {
        $mascota = Mascota::findOrFail($id);
        $urlBase = config('app.frontend_url');
        $url = "{$urlBase}mascota/perfil/{$mascota->id}";

        $qrCode = base64_decode(DNS2D::getBarcodePNG($url, 'QRCODE', 5, 5));

        $fileName = "qr_mascota_{$mascota->id}.png";

        return Response::make($qrCode, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => "attachment; filename=\"$fileName\""
        ]);
    }

    public function destroy($id)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->delete();
        return response()->json(true);
    }

    private function message($type, $title, $mascota ){
        return response()->json(
            [
                "type" => $type,
                "title" => $title,
                "mascota" => $mascota
            ]
        );
    }
}
