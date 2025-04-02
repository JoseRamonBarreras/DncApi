<?php
namespace App\Services;
use App\Interfaces\UploadServiceInterface;
use Str;

class UploadService implements UploadServiceInterface{
	public function uploadFile($file, $path){
	    $image = $file;  // your base64 encoded
	    $image = str_replace('data:image/png;base64,', '', $image);
	    $image = str_replace(' ', '+', $image);
	    $imageName = Str::random(10).'.'.'png';
	    \File::put(storage_path(). '/app/'. $path . '/' . $imageName, base64_decode($image));	
	    return $imageName;    
	}
}