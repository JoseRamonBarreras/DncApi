<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteSuscripcion extends Model
{
    use HasFactory;

    protected $table = 'cliente_suscripciones';

    protected $fillable = [
        'cliente_id',
        'plan_id',
        'stripe_subscription_id',
        'fecha_inicio',
        'fecha_fin',
        'status',
        'trial_ends_at',
        'cancelled_at',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'trial_ends_at',
        'cancelled_at',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
