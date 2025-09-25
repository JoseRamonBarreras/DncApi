<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    use HasFactory;
    protected $table = 'opciones';
    protected $fillable = ['pregunta_id', 'texto'];

    // Opción pertenece a una pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }
}
