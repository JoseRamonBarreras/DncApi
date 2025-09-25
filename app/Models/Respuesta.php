<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;
    protected $table = 'respuestas';
    protected $fillable = ['encuesta_id', 'pregunta_id', 'empleado_id', 'respuesta_texto', 'opcion_id'];

    // Respuesta pertenece a una encuesta
    public function encuesta()
    {
        return $this->belongsTo(Encuesta::class);
    }

    // Respuesta pertenece a una pregunta
    public function pregunta()
    {
        return $this->belongsTo(Pregunta::class);
    }

    // Respuesta pertenece a un empleado
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Respuesta puede estar ligada a una opción (si es opción múltiple)
    public function opcion()
    {
        return $this->belongsTo(Opcion::class);
    }
}
