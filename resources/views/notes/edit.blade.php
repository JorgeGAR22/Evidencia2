@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header"><h2>Editar Nota</h2></div>

                <div class="card-body">
                    <form action="{{ route('notes.update', $note->id) }}" method="POST">
                        @csrf {{-- Protección CSRF --}}
                        @method('PUT') {{-- Método PUT para actualizar --}}

                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $note->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenido</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5" required>{{ old('content', $note->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Actualizar Nota</button>
                        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsectionphp artisan serve