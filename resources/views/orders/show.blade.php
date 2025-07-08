@extends('adminlte::page')

@section('title', 'Detalles de Orden')

@section('content_header')
    <h1>Detalles de Orden: #{{ $order->invoice_number }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la Orden</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Número de Factura:</strong> {{ $order->invoice_number }}</p>
                    <p><strong>Cliente:</strong> {{ $order->customer_name }}</p>
                    <p><strong>Email Cliente:</strong> {{ $order->customer_email ?? 'N/A' }}</p>
                    <p><strong>Teléfono Cliente:</strong> {{ $order->customer_phone ?? 'N/A' }}</p>
                    <p><strong>Dirección de Entrega:</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Monto Total:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                    <p><strong>Creada Por:</strong> {{ $order->creator->name ?? 'N/A' }}</p>
                    <p><strong>Fecha de Orden:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Última Actualización:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                    <p><strong>Estado:</strong>
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
                    </p>
                </div>
                <div class="col-md-6">
                    <h4>Detalles del Proceso:</h4>
                    <p><strong>Nombre del Proceso:</strong> {{ $order->process_name ?? 'N/A' }}</p>
                    <p><strong>Fecha del Proceso:</strong> {{ $order->process_date ? $order->process_date->format('d/m/Y H:i') : 'N/A' }}</p>

                    <h4>Evidencias Fotográficas:</h4>
                    @if ($order->in_route_photo_path)
                        <p><strong>Foto en Ruta:</strong></p>
                        <img src="{{ Storage::url($order->in_route_photo_path) }}" alt="Foto en Ruta" class="img-fluid mb-2" style="max-width: 300px;">
                        <br><a href="{{ Storage::url($order->in_route_photo_path) }}" target="_blank">Ver en tamaño completo</a>
                    @else
                        <p>No hay foto en ruta.</p>
                    @endif

                    @if ($order->delivered_photo_path)
                        <p class="mt-3"><strong>Foto de Entrega:</strong></p>
                        <img src="{{ Storage::url($order->delivered_photo_path) }}" alt="Foto de Entrega" class="img-fluid mb-2" style="max-width: 300px;">
                        <br><a href="{{ Storage::url($order->delivered_photo_path) }}" target="_blank">Ver en tamaño completo</a>
                    @else
                        <p>No hay foto de entrega.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('orders.edit', $order) }}" class="btn btn-info"><i class="fas fa-edit"></i> Editar Orden</a>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver al Listado</a>
        </div>
    </div>
@stop

@section('css')
    {{-- CSS adicional si es necesario --}}
@stop

@section('js')
    {{-- JS adicional si es necesario --}}
@stop
