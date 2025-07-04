<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEnvio extends Model
{
    use HasFactory;
    protected $table = 'tipo_envios';

    public function clientesEnvioConfig()
    {
        return $this->hasMany(ClienteEnvioConfig::class);
    }
}
