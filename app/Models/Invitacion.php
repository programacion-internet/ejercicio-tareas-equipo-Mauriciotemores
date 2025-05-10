<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Invitacion extends Pivot
{
    protected $table = 'tarea_user';

    protected $fillable = [
        'tarea_id',
        'user_id',
        'token',
        'aceptada'
    ];

    protected $casts = [
        'aceptada' => 'boolean'
    ];
}
