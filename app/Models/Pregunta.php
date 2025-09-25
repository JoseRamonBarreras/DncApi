<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    use HasFactory;
    protected $table = 'preguntas';
    protected $fillable = ['encuesta_id', 'texto', 'tipo']; // tipo puede ser: abierta, opción múltiple, etc.

    // Una pregunta pertenece a una encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class);
    }

    // Una pregunta puede tener varias opciones
    public function opciones()
    {
        return $this->hasMany(Opcion::class, 'pregunta_id');
    }

    // Una pregunta tiene muchas respuestas
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id');
    }
}
