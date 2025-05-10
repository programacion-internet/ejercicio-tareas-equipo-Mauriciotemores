@can('invite', $tarea)
<div class="mt-3 p-3 bg-light rounded">
    <h6>Invitar a equipo:</h6>
    <form action="{{ route('tareas.invite', $tarea) }}" method="POST" class="form-inline">
        @csrf
        <select name="user_id" class="form-control mr-2" required>
            <option value="">Seleccionar usuario...</option>
            @foreach($usuariosDisponibles as $user)
                @unless($tarea->participantes->contains($user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endunless
            @endforeach
        </select>
        <button type="submit" class="btn btn-sm btn-primary">
            Invitar
        </button>
    </form>
    
    @if($tarea->participantes->isNotEmpty())
        <div class="mt-2">
            <small>Participantes:</small>
            <div class="d-flex flex-wrap">
                @foreach($tarea->participantes as $participante)
                    <span class="badge bg-secondary me-1 mb-1">
                        {{ $participante->name }}
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endcan