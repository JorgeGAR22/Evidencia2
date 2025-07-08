@extends('adminlte::page')

@section('title', 'Órdenes Archivadas')

@section('content_header')
    <h1>Órdenes Archivadas</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Órdenes Archivadas (Eliminadas Lógicamente)</h3>
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

            {{-- Formulario de Búsqueda y Filtro para órdenes archivadas (opcional, si lo necesitas) --}}
            {{--
            <form action="{{ route('orders.archived') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search_invoice_number">Buscar por # Factura:</label>
                            <input type="text" name="search_invoice_number" id="search_invoice_number" class="form-control" value="{{ request('search_invoice_number') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="search_customer_name">Buscar por Nombre Cliente:</label>
                            <input type="text" name="search_customer_name" id="search_customer_name" class="form-control" value="{{ request('search_customer_name') }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-info mr-2"><i class="fas fa-search"></i> Buscar</button>
                        <a href="{{ route('orders.archived') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Limpiar</a>
                    </div>
                </div>
            </form>
            --}}

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th># Factura</th>
                        <th>Cliente</th>
                        <th>Estado Original</th>
                        <th>Archivada El</th>
                        <th>Acciones</th>
                    </tr>
</thead>
                <tbody>
                    {{-- Asegúrate de que $archivedOrders se está pasando correctamente desde el controlador --}}
                    @forelse ($archivedOrders as $order)
                        <tr>
                            <td>{{ $order->invoice_number }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>
                                @php
                                    $badgeClass = '';
                                    switch ($order->status) {
                                        case 'ordered': $badgeClass = 'badge-primary'; break;
                                        case 'in_process': $badgeClass = 'badge-info'; break;
                                        case 'in_route': $badgeClass = 'badge-warning'; break;
                                        case 'delivered': $badgeClass = 'badge-success'; break;
                                        case 'cancelled': $badgeClass = 'badge-danger'; break;
                                        default: $badgeClass = 'badge-secondary'; break;
                                    }
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                            </td>
                            <td>{{ $order->deleted_at ? $order->deleted_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                {{-- Formulario para restaurar la orden --}}
                                <form action="{{ route('orders.restore', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-xs"
                                            onclick="return confirm('¿Estás seguro de restaurar esta orden?')">
                                        <i class="fas fa-undo"></i> Restaurar
                                    </button>
                                </form>
                                {{-- Opcional: Eliminar permanentemente (si se necesita, pero la tarea pide "lógica") --}}
                                {{--
                                <form action="{{ route('orders.forceDelete', $order->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('¿Estás seguro de ELIMINAR PERMANENTEMENTE esta orden? Esta acción no se puede deshacer.')">
                                        <i class="fas fa-trash-alt"></i> Eliminar Permanente
                                    </button>
                                </form>
                                --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay órdenes archivadas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Paginación (si usas paginación en el controlador) --}}
            <div class="d-flex justify-content-center">
                {{ $archivedOrders->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- CSS adicional si es necesario --}}
@stop

@section('js')
    {{-- Script para que las alertas de Bootstrap se cierren automáticamente (opcional) --}}
    <script>
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
@stop
