@extends('layouts.app')

@section('title', 'Editar Tarea')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Editar Tarea</h1>
        
        <form action="{{ route('tareas.update', $tarea) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" 
                       value="{{ old('nombre', $tarea->nombre) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" 
                          rows="3">{{ old('descripcion', $tarea->descripcion) }}</textarea>
            </div>
            
            <div class="mb-3">
                <label for="fecha_limite" class="form-label">Fecha Límite</label>
                <input type="date" class="form-control" id="fecha_limite" name="fecha_limite" 
                       value="{{ old('fecha_limite', $tarea->fecha_limite ? $tarea->fecha_limite->format('Y-m-d') : '') }}">
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
            <a href="{{ route('tareas.show', $tarea) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection