<?php

namespace App\Mail;

use App\Models\Tarea;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvitacionTareaMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tarea;

    public function __construct(Tarea $tarea)
    {
        $this->tarea = $tarea;
    }

    public function build()
    {
        return $this->subject('Invitación a tarea: ' . $this->tarea->nombre)
                    ->markdown('emails.invitacion-tarea', [
                        'tarea' => $this->tarea,
                        'url' => route('tareas.show', $this->tarea)
                    ]);
    }
}
