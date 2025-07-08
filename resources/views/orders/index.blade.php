@extends('adminlte::page')

@section('title', 'Gestión de Órdenes')

@section('content_header')
    <h1>Gestión de Órdenes</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de Órdenes</h3>
            <div class="card-tools">
                <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Crear Nueva Orden
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

            {{-- Formulario de Búsqueda y Filtro --}}
            <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="invoice_number">Buscar por # Factura:</label>
                            <input type="text" name="invoice_number" id="invoice_number" class="form-control" value="{{ request('invoice_number') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="customer_name">Buscar por Nombre Cliente:</label>
                            <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ request('customer_name') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Estado:</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Todos los Estados</option>
                                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                                <option value="in_process" {{ request('status') == 'in_process' ? 'selected' : '' }}>In process</option>
                                <option value="in_route" {{ request('status') == 'in_route' ? 'selected' : '' }}>In route</option>
                                <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-info mr-2"><i class="fas fa-search"></i> Buscar</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Limpiar</a>
                    </div>
                </div>
            </form>

            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th># Factura</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Monto Total</th>
                        <th>Creada Por</th>
                        <th>Fecha de Orden</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
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
                            <td>${{ number_format($order->total_amount, 2) }}</td>
                            {{-- Manejo de nulos para el creador --}}
                            <td>{{ $order->creator ? $order->creator->name : 'N/A' }}</td>
                            {{-- Manejo de nulos para la fecha de orden --}}
                            <td>{{ $order->order_date ? $order->order_date->format('d/m/Y H:i') : 'N/A' }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-xs">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                                <a href="{{ route('orders.edit', $order) }}" class="btn btn-info btn-xs">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                {{-- Formulario para eliminar lógicamente (archivar) --}}
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-xs"
                                            onclick="return confirm('¿Estás seguro de archivar esta orden? No se eliminará permanentemente.')">
                                        <i class="fas fa-archive"></i> Archivar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No hay órdenes disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Paginación (si usas paginación en el controlador) --}}
            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
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
            setTimeout(function() {
                $(".alert").alert('close');
            }, 5000);
        });
    </script>
@stop
