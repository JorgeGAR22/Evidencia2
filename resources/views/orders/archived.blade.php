@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">=C3=93rdenes Archivadas (Eliminadas L=C3=B3gicamente)</div>

            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Volver a =C3=93rdenes Activas</a>
                </div>

                <form action="{{ route('orders.archived') }}" method="GET" class="d-flex mb-3">
                    <input type="text" name="search_invoice_number" class="form-control me-2" placeholder="Buscar por # Factura" value="{{ request('search_invoice_number') }}">
                    <input type="text" name="search_customer_name" class="form-control me-2" placeholder="Buscar por Nombre Cliente" value="{{ request('search_customer_name') }}">
                    <input type="date" name="search_date" class="form-control me-2" value="{{ request('search_date') }}">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <a href="{{ route('orders.archived') }}" class="btn btn-link">Limpiar</a>
                </form>

                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th># Factura</th>
                            <th>Cliente</th>
                            <th>Estado</th>
                            <th>Monto Total</th>
                            <th>Archivada Por</th>
                            <th>Fecha de Archivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($archivedOrders as $order)
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
                                <td>{{ $order->user->name ?? 'N/A' }}</td> {{-- Asumiendo que el usuario que la cre=C3=B3 se muestra --}}
                                <td>{{ $order->deleted_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info me-1">Ver</a>
                                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-warning me-1">Editar</a>
                                    <form action="{{ route('orders.restore', $order->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('=C2=BFEst=C3=A1s seguro de que quieres restaurar esta orden?');">Restaurar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">No hay =C3=B3rdenes archivadas para mostrar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    {{ $archivedOrders->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
