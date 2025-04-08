<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mascota;

class Especie extends Model
{
    use HasFactory;
    protected $table = "especies";
    protected $fillable = ["id", "especie"];

    public function mascotas()
    {
        return $this->hasMany(Mascota::class);
    }


}
