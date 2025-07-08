@extends('adminlte::page') {{-- Extiende la plantilla principal de AdminLTE --}}

@section('title', 'Gestión de Usuarios')

@section('content_header')
    <h1>Gestión de Usuarios</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Usuarios</h3>
            <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Nuevo Usuario
                </a>
            </div>
        </div>
        <div class="card-body">
            {{-- Sección para mostrar alertas (éxito, error, etc.) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol/Departamento</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Itera sobre la colección de usuarios pasada desde el controlador --}}
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role ? $user->role->name : 'N/A' }}</td> {{-- Asumiendo que tienes una relación 'role' --}}
                            <td>
                                @if ($user->is_active)
                                    <span class="badge badge-success">Activo</span>
                                @else
                                    <span class="badge badge-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                {{-- Formulario para cambiar estado (Activo/Inactivo) --}}
                                <form action="{{ route('users.toggleActive', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn {{ $user->is_active ? 'btn-warning' : 'btn-success' }} btn-xs"
                                            onclick="return confirm('¿Estás seguro de cambiar el estado de este usuario?')">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i> {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    {{-- Aquí puedes añadir CSS adicional si lo necesitas --}}
@stop

@section('js')
    {{-- Script para que las alertas de Bootstrap se cierren automáticamente (opcional) --}}
    <script>
        $(document).ready(function() {
            // Cierra las alertas después de 5 segundos
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
@stop
