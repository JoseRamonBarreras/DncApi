<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mascota;
use App\Models\Especie;
use App\Interfaces\UploadServiceInterface;

class MascotaController extends Controller
{

    public function index()
    {
        $header = apache_request_headers();
        $rol = $header['role'];
        $id = $header['user_id'];
        return Mascota::with('especie')->where('user_id', $id)->select('id', 'name', 'birthday', 'phone', 'especie_id', 'foto')->get();
    }

    public function especies()
    {
        return Especie::all();
    }


    public function store(Request $request, UploadServiceInterface $uploadService)
    {
        $mascota = new Mascota();
        $mascota->name = $request->name;
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
        //
    }


    public function update(Request $request, $id, UploadServiceInterface $uploadService)
    {
        $mascota = Mascota::findOrFail($id);
        $mascota->name = $request->name;
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
