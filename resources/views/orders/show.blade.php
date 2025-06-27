@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Detalles de la Orden: #{{ $order->invoice_number }}</div>

            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>ID de Orden:</strong> {{ $order->id }}</li>
                    <li class="list-group-item"><strong>Número de Factura:</strong> {{ $order->invoice_number }}</li>
                    <li class="list-group-item"><strong>Nombre del Cliente:</strong> {{ $order->customer_name }}</li>
                    <li class="list-group-item"><strong>Email del Cliente:</strong> {{ $order->customer_email ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Teléfono del Cliente:</strong> {{ $order->customer_phone ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Dirección de Envío:</strong> {{ $order->shipping_address }}</li>
                    <li class="list-group-item"><strong>Monto Total:</strong> ${{ number_format($order->total_amount, 2) }}</li>
                    <li class="list-group-item">
                        <strong>Estado:</strong>
                        <span class="badge bg-{{
                            $order->status == 'pending' ? 'warning text-dark' :
                            ($order->status == 'in_process' ? 'info' :
                            ($order->status == 'in_route' ? 'primary' :
                            ($order->status == 'delivered' ? 'success' :
                            'danger')))
                        }}">
                            {{ str_replace('_', ' ', ucfirst($order->status)) }}
                        </span>
                    </li>
                    <li class="list-group-item"><strong>Creada Por:</strong> {{ $order->user->name ?? 'N/A' }}</li>
                    <li class="list-group-item"><strong>Fecha de Orden:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</li>
                    <li class="list-group-item"><strong>Última Actualización:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</li>

                    @if ($order->process_name)
                        <li class="list-group-item"><strong>Nombre del Proceso:</strong> {{ $order->process_name }}</li>
                        <li class="list-group-item"><strong>Fecha de Proceso:</strong> {{ $order->process_date ? $order->process_date->format('d/m/Y H:i') : 'N/A' }}</li>
                    @endif

                    @if ($order->in_route_photo_path)
                        <li class="list-group-item">
                            <strong>Foto en Ruta:</strong><br>
                            <img src="{{ Storage::url($order->in_route_photo_path) }}" alt="Foto en Ruta" class="img-fluid mt-2" style="max-height: 300px;">
                        </li>
                    @endif

                    @if ($order->delivered_photo_path)
                        <li class="list-group-item">
                            <strong>Foto de Entrega:</strong><br>
                            <img src="{{ Storage::url($order->delivered_photo_path) }}" alt="Foto de Entrega" class="img-fluid mt-2" style="max-height: 300px;">
                        </li>
                    @endif

                    @if ($order->trashed())
                        <li class="list-group-item text-danger"><strong>Estado:</strong> Archivada (Eliminada Lógicamente el {{ $order->deleted_at->format('d/m/Y H:i') }})</li>
                    @endif
                </ul>

                <div class="mt-4">
                    <a href="{{ route('orders.edit', $order) }}" class="btn btn-warning me-2">Editar Orden</a>
                    @if ($order->trashed())
                        <form action="{{ route('orders.restore', $order->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Restaurar Orden</button>
                        </form>
                    @else
                        <form action="{{ route('orders.destroy', $order) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres archivar esta orden?');">Archivar Orden</button>
                        </form>
                    @endif
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary float-end">Volver a Órdenes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
