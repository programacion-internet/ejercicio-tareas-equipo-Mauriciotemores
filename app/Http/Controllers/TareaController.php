<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTareaRequest;
use App\Http\Requests\UpdateTareaRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvitacionTareaMail;
use Illuminate\Routing\Controller as BaseController;

class TareaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Obtener tareas del usuario actual (creadas o donde participa)
        $tareas = auth()->user()->tareasCreadas()
                    ->orWhereHas('participantes', function($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->with('participantes')
                    ->latest()
                    ->get();

        return view('tareas.index', [
            'tareas' => $tareas,
            'usuariosDisponibles' => User::where('id', '!=', auth()->id())->get()
        ]);
    }

    public function create()
    {
        return view('tareas.create');
    }

    public function store(StoreTareaRequest $request)
    {
        $tarea = auth()->user()->tareasCreadas()->create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_limite' => $request->fecha_limite
        ]);

        return redirect()->route('tareas.show', $tarea)
            ->with('success', 'Tarea creada correctamente');
    }

    public function show(Tarea $tarea)
    {
        $this->authorize('view', $tarea);

        return view('tareas.show', [
            'tarea' => $tarea,
            'usuariosDisponibles' => User::where('id', '!=', auth()->id())->get()
        ]);
    }

    public function edit(Tarea $tarea)
    {
        $this->authorize('update', $tarea);

        return view('tareas.edit', compact('tarea'));
    }

    public function update(UpdateTareaRequest $request, Tarea $tarea)
    {
        $this->authorize('update', $tarea);

        $tarea->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_limite' => $request->fecha_limite
        ]);

        return redirect()->route('tareas.show', $tarea)
            ->with('success', 'Tarea actualizada correctamente');
    }

    public function destroy(Tarea $tarea)
    {
        $this->authorize('delete', $tarea);

        $tarea->delete();

        return redirect()->route('tareas.index')
            ->with('success', 'Tarea eliminada correctamente');
    }

    public function invite(Request $request, Tarea $tarea)
    {
        $this->authorize('invite', $tarea);

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $usuario = User::findOrFail($request->user_id);

        if($tarea->participantes()->where('user_id', $usuario->id)->exists()) {
            return back()->with('error', 'Este usuario ya fue invitado');
        }

        $tarea->participantes()->attach($usuario->id, [
            'token' => \Illuminate\Support\Str::random(32),
            'aceptada' => false
        ]);

        Mail::to($usuario->email)->send(new InvitacionTareaMail($tarea));

        return back()->with('success', 'Invitación enviada correctamente');
    }
}
