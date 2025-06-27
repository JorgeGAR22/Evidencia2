@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Listado de Notas</h2>
                    <a href="{{ route('notes.create') }}" class="btn btn-primary">Crear Nueva Nota</a>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($notes->isEmpty())
                        <p class="text-center">No hay notas registradas. ¡Crea la primera!</p>
                    @else
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Título</th>
                                    <th>Contenido</th>
                                    <th>Fecha Creación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notes as $note)
                                    <tr>
                                        <td>{{ $note->id }}</td>
                                        <td>{{ $note->title }}</td>
                                        <td>{{ Str::limit($note->content, 50) }}</td> {{-- Muestra solo los primeros 50 caracteres --}}
                                        <td>{{ $note->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('notes.show', $note->id) }}" class="btn btn-info btn-sm">Ver</a>
                                            <a href="{{ route('notes.edit', $note->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta nota?');">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $notes->links() }} {{-- Para la paginación si se usa --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection