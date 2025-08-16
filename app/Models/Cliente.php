<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'clientes';

     protected $fillable = [
        'nombre',
        'email',
        'fecha_registro',
        'fecha_vencimiento',
        'status_id',
        'plan_id'
    ];

    protected $dates = ['fecha_registro', 'fecha_vencimiento'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function config()
    {
        return $this->hasOne(ClienteConfig::class);
    }

    public function puestos()
    {
        return $this->hasMany(Puesto::class);
    }

    public function puestosActivos()
    {
        return $this->hasMany(Puesto::class)->where('activo', true);
    }

    public function suscripciones()
    {
        return $this->hasMany(ClienteSuscripcion::class);
    }

    // Para obtener la suscripción activa actual (si decides manejarlo así)
    public function suscripcionActiva()
    {
        return $this->hasOne(ClienteSuscripcion::class)->where('status', 'activo');
    }
}
