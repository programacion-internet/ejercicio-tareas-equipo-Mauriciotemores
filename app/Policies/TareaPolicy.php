<?php

namespace App\Policies;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TareaPolicy
{
    public function viewAny(User $user): bool
    {
        // Solo usuarios autenticados pueden ver listados de tareas
        return $user !== null;
    }

    public function view(User $user, Tarea $tarea): Response
    {
        // El creador de la tarea siempre puede verla
        if ($user->id === $tarea->user_id) {
            return Response::allow();
        }

        // Usuarios invitados que hayan aceptado la invitación pueden verla
        if ($user->tareasParticipantes()
                ->where('tarea_id', $tarea->id)
                ->where('aceptada', true)
                ->exists()) {
            return Response::allow();
        }

        return Response::deny('No tienes permiso para ver esta tarea');
    }

    public function create(User $user): bool
    {
        // Cualquier usuario autenticado puede crear tareas
        return $user !== null;
    }

    public function update(User $user, Tarea $tarea): Response
    {
        // Solo el creador puede editar la tarea
        return $user->id === $tarea->user_id
            ? Response::allow()
            : Response::deny('Solo el creador puede modificar esta tarea');
    }

    public function delete(User $user, Tarea $tarea): Response
    {
        // Solo el creador puede eliminar la tarea
        return $user->id === $tarea->user_id
            ? Response::allow()
            : Response::deny('Solo el creador puede eliminar esta tarea');
    }

    public function restore(User $user, Tarea $tarea): bool
    {
        return false;
    }

    public function forceDelete(User $user, Tarea $tarea): bool
    {
        return false;
    }

    public function invite(User $user, Tarea $tarea): Response
    {
        // Solo el creador puede invitar a otros
        return $user->id === $tarea->user_id
            ? Response::allow()
            : Response::deny('Solo el creador puede invitar participantes');
    }

    public function uploadFiles(User $user, Tarea $tarea): Response
    {
        // El creador o participantes aceptados pueden subir archivos
        if ($user->id === $tarea->user_id || 
            $user->tareasParticipantes()
                ->where('tarea_id', $tarea->id)
                ->where('aceptada', true)
                ->exists()) {
            return Response::allow();
        }

        return Response::deny('No tienes permiso para subir archivos a esta tarea');
    }

    public function deleteFiles(User $user, Tarea $tarea): Response
    {
        // Solo el creador puede eliminar archivos (o el dueño del archivo?)
        return $user->id === $tarea->user_id
            ? Response::allow()
            : Response::deny('Solo el creador puede eliminar archivos de esta tarea');
    }
}