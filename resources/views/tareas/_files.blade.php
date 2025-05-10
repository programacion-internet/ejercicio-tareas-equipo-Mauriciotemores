<div class="mt-4">
    <h5>Archivos</h5>
    
    @can('uploadFiles', $tarea)
        <form action="{{ route('tareas.files.store', $tarea) }}" method="POST" enctype="multipart/form-data" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="file" name="archivo" class="form-control" required>
                <button type="submit" class="btn btn-primary">Subir</button>
            </div>
        </form>
    @endcan
    
    @if($tarea->archivos->isEmpty())
        <div class="alert alert-info">No hay archivos subidos</div>
    @else
        <div class="list-group">
            @foreach($tarea->archivos as $archivo)
                <div class="list-group-item">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="{{ Storage::url($archivo->ruta) }}" target="_blank" download="{{ $archivo->nombre_original }}">
                                {{ $archivo->nombre_original }}
                            </a>
                            <small class="d-block text-muted">
                                Subido por: {{ $archivo->user->name }} - 
                                {{ $archivo->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        @if(auth()->id() === $archivo->user_id || auth()->id() === $tarea->user_id)
                            <form action="{{ route('tareas.files.destroy', [$tarea, $archivo]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>