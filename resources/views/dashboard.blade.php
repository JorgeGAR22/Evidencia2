@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Dashboard Administrativo') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <p>Bienvenido, {{ Auth::user()->name }} (Rol: {{ Auth::user()->role->name ?? 'N/A' }}, Depto: {{ Auth::user()->department->name ?? 'N/A' }}).</p>
                <p>Desde aquí puedes gestionar los recursos de la aplicación.</p>

                <div class="list-group">
                    <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action">
                        Gestión de Usuarios
                    </a>
                    <a href="{{ route('orders.index') }}" class="list-group-item list-group-item-action">
                        Gestión de Órdenes
                    </a>
                    <a href="{{ route('orders.archived') }}" class="list-group-item list-group-item-action">
                        Órdenes Archivadas
                    </a>
                    <!-- Puedes añadir más enlaces aquí para otras funcionalidades -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
