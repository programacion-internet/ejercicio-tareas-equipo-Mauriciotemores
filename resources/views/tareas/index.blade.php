@extends('components.layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Mis Tareas</h1>
    
    <div class="mb-4">
        <a href="{{ route('tareas.create') }}" class="btn btn-primary">
            Crear Nueva Tarea
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @if($tareas->isEmpty())
                <div class="alert alert-info">No hay tareas registradas</div>
            @else
                <div class="list-group">
                    @foreach($tareas as $tarea)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5>
                                        <a href="{{ route('tareas.show', $tarea) }}">
                                            {{ $tarea->nombre }}
                                        </a>
                                    </h5>
                                    <small class="text-muted">
                                        Fecha límite: {{ $tarea->fecha_limite->format('d/m/Y') }}
                                    </small>
                                </div>
                                
                                <div class="btn-group">
                                    @can('update', $tarea)
                                        <a href="{{ route('tareas.edit', $tarea) }}" class="btn btn-sm btn-outline-secondary">
                                            Editar
                                        </a>
                                    @endcan
                                    
                                    @can('delete', $tarea)
                                        <form action="{{ route('tareas.destroy', $tarea) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                            
                            @include('tareas._invite', ['tarea' => $tarea])
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection