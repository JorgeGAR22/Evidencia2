@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">Gestión de Usuarios</div>

            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Nuevo Usuario</a>
                    <form action="{{ route('users.index') }}" method="GET" class="d-flex">
                        <select name="status" class="form-select me-2" onchange="this.form.submit()">
                            <option value="">Todos los usuarios</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Usuarios Activos</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Usuarios Inactivos</option>
                        </select>
                    </form>
                </div>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Departamento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name ?? 'N/A' }}</td>
                                <td>{{ $user->department->name ?? 'N/A' }}</td>
                                <td>
                                    @if ($user->is_active)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-info me-1">Editar</a>
                                    <form action="{{ route('users.toggleActive', $user) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-warning' : 'btn-success' }}">
                                            {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay usuarios para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection