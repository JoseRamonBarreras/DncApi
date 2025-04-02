<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitacionMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $datos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->datos = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.invitacion')->with([
            'usuario' => $this->datos->usuario,
            'titulo' => $this->datos->titulo,
            'empresa' => $this->datos->empresa,
            'clave' => $this->datos->clave,
            'fecha' => $this->datos->fecha,
            'revision' => $this->datos->revision,
        ]);
    }
}
