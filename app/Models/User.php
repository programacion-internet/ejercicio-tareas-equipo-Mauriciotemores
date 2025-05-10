<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relación con tareas creadas (owner)
    public function tareasCreadas()
    {
        return $this->hasMany(Tarea::class, 'user_id');
    }

    // Relación con tareas donde participa (a través de invitaciones)
    public function tareasParticipantes()
    {
        return $this->belongsToMany(Tarea::class, 'tarea_user')
                    ->withPivot(['token', 'aceptada', 'created_at'])
                    ->using(Invitacion::class)
                    ->withTimestamps();
    }

    // Método para ver todas las tareas (propias y donde participa)
    public function todasLasTareas()
    {
        return $this->tareasCreadas->merge($this->tareasParticipantes);
    }

    // Método para verificar si es participante de una tarea específica
    public function esParticipante(Tarea $tarea)
    {
        return $this->tareasParticipantes()
                   ->where('tarea_id', $tarea->id)
                   ->where('aceptada', true)
                   ->exists();
    }

    // Método para aceptar una invitación
    public function aceptarInvitacion(Tarea $tarea, string $token)
    {
        return $this->tareasParticipantes()
                   ->where('tarea_id', $tarea->id)
                   ->where('token', $token)
                   ->update(['aceptada' => true]);
    }

    // Iniciales del usuario (para avatares)
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->take(2)
            ->implode('')
            ->upper();
    }
}
