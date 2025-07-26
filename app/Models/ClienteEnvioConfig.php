<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEnvioConfig extends Model
{
    use HasFactory;
    protected $table = 'clientes_envio_config';

    protected $fillable = [
        'tipo_envio_id',
        'precio_fijo',
        'permite_entrega_domicilio',
        'permite_recoger_sucursal',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function tipoEnvio()
    {
        return $this->belongsTo(TipoEnvio::class);
    }

    public function rangos()
    {
        return $this->hasMany(EnvioRango::class, 'clientes_envio_config_id');
    }
}
