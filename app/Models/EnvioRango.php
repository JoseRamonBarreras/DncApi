<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioRango extends Model
{
    use HasFactory;
    protected $table = 'envio_rangos';

    protected $fillable = [
        'km_min',
        'km_max',
        'precio',
        'clientes_envio_config_id'
    ];

    public function envioConfig()
    {
        return $this->belongsTo(ClienteEnvioConfig::class, 'clientes_envio_config_id');
    }
}
