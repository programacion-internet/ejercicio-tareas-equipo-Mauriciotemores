@extends('components.layouts.app')

@section('title', 'Crear Nueva Tarea')

@section('content')
    <div class="container py-4">
        <h1 class="mb-4">Crear Nueva Tarea</h1>
        
        <form action="{{ route('tareas.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="fecha_limite" class="form-label">Fecha Límite</label>
                <input type="date" class="form-control" id="fecha_limite" name="fecha_limite">
            </div>
            
            <button type="submit" class="btn btn-primary">Crear Tarea</button>
            <a href="{{ route('tareas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection