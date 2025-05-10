<?php

namespace App\Policies;

use App\Models\Archivo;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ArchivoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Permite ver archivos si el usuario está autenticado
        return $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Archivo $archivo): bool
    {
        // Permite ver si el usuario es creador o participante aceptado
        return $user->tareasParticipantes()
            ->where('tarea_id', $archivo->tarea_id)
            ->where('aceptada', true)
            ->exists() || $user->id === $archivo->tarea->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Permite crear archivos a cualquier usuario autenticado
        return $user !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Archivo $archivo): bool
    {
        // Solo el creador del archivo o de la tarea puede actualizar
        return $user->id === $archivo->user_id || $user->id === $archivo->tarea->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Archivo $archivo): bool
    {
        // Solo el creador del archivo o de la tarea puede eliminar
        return $user->id === $archivo->user_id || $user->id === $archivo->tarea->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Archivo $archivo): bool
    {
        // No permitir restaurar por defecto
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Archivo $archivo): bool
    {
        // Solo el creador de la tarea puede borrar permanentemente
        return $user->id === $archivo->tarea->user_id;
    }
}
