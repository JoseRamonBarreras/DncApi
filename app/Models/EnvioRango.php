<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnvioRango extends Model
{
    use HasFactory;
    protected $table = 'envio_rangos';

    public function envioConfig()
    {
        return $this->belongsTo(ClienteEnvioConfig::class, 'clientes_envio_config_id');
    }
}
