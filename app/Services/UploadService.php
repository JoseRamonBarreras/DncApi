<?php
namespace App\Services;
use App\Interfaces\UploadServiceInterface;
use Str;
use Illuminate\Support\Facades\File;
use Exception;

class UploadService implements UploadServiceInterface{
	public function uploadFile($file, $path)
    {
        // Validar y extraer el tipo de imagen
        if (preg_match('/^data:image\/(\w+);base64,/', $file, $type)) {
            $image = substr($file, strpos($file, ',') + 1);
            $extension = strtolower($type[1]); // png, jpg, jpeg, gif, etc.

            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new Exception('Formato de imagen no soportado');
            }

            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.' . $extension;

            $fullPath = storage_path('app/' . $path . '/' . $imageName);

            // Asegurarse que el directorio existe
            if (!File::exists(dirname($fullPath))) {
                File::makeDirectory(dirname($fullPath), 0755, true);
            }

            File::put($fullPath, base64_decode($image));

            return $imageName;
        } else {
            throw new Exception('Formato base64 no válido');
        }
    }
}