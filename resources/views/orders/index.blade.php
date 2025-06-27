@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Gestión de Órdenes</div>

            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <a href="{{ route('orders.create') }}" class="btn btn-primary">Crear Nueva Orden</a>
                    <form action="{{ route('orders.index') }}" method="GET" class="d-flex w-75">
                        <input type="text" name="search_invoice_number" class="form-control me-2" placeholder="Buscar por # Factura" value="{{ request('search_invoice_number') }}">
                        <input type="text" name="search_customer_name" class="form-control me-2" placeholder="Buscar por Nombre Cliente" value="{{ request('search_customer_name') }}">
                        <input type="date" name="search_date" class="form-control me-2" value="{{ request('search_date') }}">
                        <select name="search_status" class="form-select me-2">
                            <option value="all">Todos los Estados</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ request('search_status') === $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', ucfirst($status)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-secondary">Buscar</button>
                        <a href="{{ route('orders.index') }}" class="btn btn-link">Limpiar</a>
                    </form>
                </div>

                <table class="table table-bordered table-striped">
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
                                    <span class="badge bg-{{
                                        $order->status == 'pending' ? 'warning text-dark' :
                                        ($order->status == 'in_process' ? 'info' :
                                        ($order->status == 'in_route' ? 'primary' :
                                        ($order->status == 'delivered' ? 'success' :
                                        'danger')))
                                    }}">
                                        {{ str_replace('_', ' ', ucfirst($order->status)) }}
                                    </span>
                                </td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td>{{ $order->user->name ?? 'N/A' }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info me-1">Ver</a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                                    <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que quieres archivar esta orden?');">Archivar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay órdenes activas para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $orders->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection