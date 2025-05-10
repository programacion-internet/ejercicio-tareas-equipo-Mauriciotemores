@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $tarea->nombre }}</h4>
                <div>
                    @can('update', $tarea)
                        <a href="{{ route('tareas.edit', $tarea) }}" class="btn btn-light btn-sm">
                            Editar
                        </a>
                    @endcan
                </div>
            </div>
        </div>
        
        <div class="card-body">
            <div class="mb-4">
                <h5>Descripción:</h5>
                <p class="text-muted">{{ $tarea->descripcion }}</p>
                
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Creada por:</strong> {{ $tarea->owner->name }}
                        </small>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <small class="text-muted">
                            <strong>Fecha límite:</strong> {{ $tarea->fecha_limite->format('d/m/Y') }}
                        </small>
                    </div>
                </div>
            </div>
            
            <hr>
            
            @include('tareas._invite', ['tarea' => $tarea])
            
            <hr>
            
            @include('tareas._files', ['tarea' => $tarea])
        </div>
    </div>
</div>
@endsection