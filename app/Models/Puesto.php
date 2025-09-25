<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    use HasFactory;
    protected $table = 'puestos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'cliente_id',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function jefes()
    {
        return $this->hasMany(User::class, 'puesto_id');
    }

    public function encuestas()
    {
        return $this->hasMany(Encuesta::class, 'puesto_id');
    }
}
