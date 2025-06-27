@extends('layouts.app') {{-- Esto extiende el layout principal de la aplicación --}}

@section('content') {{-- Esta sección se inyecta en el layout principal --}}
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div> {{-- Encabezado de la tarjeta --}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1 class="text-center text-primary">¡Bienvenido al Dashboard, usuario registrado!</h1>
                    <p class="text-center lead">Esta es la vista a la que acceden los usuarios que han iniciado sesión.</p>
                    <div class="mt-4 text-center">
                        <p>Aquí es donde iría el contenido principal de tu aplicación (ej. el sistema de notas).</p>
                        <a href="{{ url('/') }}" class="btn btn-info me-2">Ir a la página principal (volver a Landing Page si cierras sesión)</a>
                        <a href="{{ route('notes.index') }}" class="btn btn-success">Gestionar Mis Notas</a> {{-- ¡ESTE ES EL ENLACE AL CRUD DE NOTAS! --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection