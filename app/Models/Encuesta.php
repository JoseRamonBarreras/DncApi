<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    use HasFactory;
    protected $table = 'encuestas';
    protected $fillable = ['titulo', 'descripcion', 'fecha_creacion', 'cliente_id', 'puesto_id'];

    // Una encuesta tiene muchas preguntas
    public function preguntas()
    {
        return $this->hasMany(Pregunta::class, 'encuesta_id');
    }

    // Una encuesta puede tener muchas respuestas (a través de los empleados)
    public function respuestas()
    {
        return $this->hasMany(Respuesta::class, 'encuesta_id');
    }

    // Encuesta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function puesto(){
        return $this->belongsTo(Puesto::class);
    }
}
