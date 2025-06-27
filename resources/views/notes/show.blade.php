@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Detalles de la Nota: {{ $note->title }}</h2>
                    <div>
                        <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning btn-sm me-2">Editar Nota</a>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta nota?');">Eliminar Nota</button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>ID de Usuario:</strong> {{ $note->user_id }}
                    </div>
                    <div class="mb-3">
                        <strong>Título:</strong> {{ $note->title }}
                    </div>
                    <div class="mb-3">
                        <strong>Contenido:</strong>
                        <p>{{ $note->content }}</p>
                    </div>
                    <div class="mb-3">
                        <strong>Fecha de Creación:</strong> {{ $note->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div class="mb-3">
                        <strong>Última Actualización:</strong> {{ $note->updated_at->format('d/m/Y H:i') }}
                    </div>
                    <a href="{{ route('notes.index') }}" class="btn btn-secondary">Volver al Listado</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection