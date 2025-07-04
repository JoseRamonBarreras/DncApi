<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteHorario extends Model
{
    use HasFactory;
    protected $table = 'clientes_horarios';

    protected $fillable = [
        'dia_semana',
        'abre_desde',
        'cierra_hasta',
        'activo',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
