<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nombre',
        'descripcion',
        'fecha_limite',
    ];

    protected $casts = [
        'fecha_limite' => 'date',
    ];

    // Relación con el creador (owner)
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relación many-to-many con usuarios (participantes)
    public function participantes()
    {
        return $this->belongsToMany(User::class, 'tarea_user')
                    ->withPivot('token', 'aceptada')
                    ->withTimestamps()
                    ->using(Invitacion::class);
    }

    // Relación con archivos
    public function archivos()
    {
        return $this->hasMany(Archivo::class);
    }
}
