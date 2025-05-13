<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Especie;

class Mascota extends Model
{
    use HasFactory;
    protected $table = "mascotas";
    protected $fillable = ["id", "name", "descripcion", "birthday", "phone", "user_id", "especie_id", "foto"];

    public function especie()
    {
        return $this->belongsTo(Especie::class, 'especie_id');
    }


}
