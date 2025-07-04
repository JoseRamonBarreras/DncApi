<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteConfig extends Model
{
    use HasFactory;
    protected $table = 'clientes_config';

    protected $fillable = [
        'logo_url',
        'portada_url',
        'tipografia',
        'direccion',
        'ubicacion_lat',
        'ubicacion_lng',
        'whatsapp',
        'cliente_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
