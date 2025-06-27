@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Editar Orden: #{{ $order->invoice_number }}</div>

            <div class="card-body">
                <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="invoice_number" class="form-label">N=C3=BAmero de Factura:</label>
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', $order->invoice_number) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nombre del Cliente / Empresa:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email del Cliente (opcional):</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email', $order->customer_email) }}">
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Tel=C3=A9fono del Cliente (opcional):</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}">
                    </div>
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Direcci=C3=B3n de Entrega:</label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Monto Total:</label>
                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->total_amount) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Orden Creada Por (Vendedor):</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Estado de la Orden:</label>
                        <select class="form-select" id="status" name="status" required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', ucfirst($status)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="process_name" class="form-label">Nombre del Proceso (si aplica):</label>
                        <input type="text" class="form-control" id="process_name" name="process_name" value="{{ old('process_name', $order->process_name) }}">
                    </div>
                    <div class="mb-3">
                        <label for="process_date" class="form-label">Fecha del Proceso (si aplica):</label>
                        <input type="datetime-local" class="form-control" id="process_date" name="process_date" value="{{ old('process_date', $order->process_date ? $order->process_date->format('Y-m-d\TH:i') : '') }}">
                    </div>

                    <!-- Campos de carga de fotos -->
                    <div class="mb-3">
                        <label for="in_route_photo" class="form-label">Foto en Ruta (solo si el estado es 'En Ruta'):</label>
                        @if ($order->in_route_photo_path)
                            <p>Foto actual: <a href="{{ Storage::url($order->in_route_photo_path) }}" target="_blank">Ver Foto</a></p>
                            <img src="{{ Storage::url($order->in_route_photo_path) }}" alt="Foto en Ruta Actual" class="img-fluid" style="max-height: 150px;">
                        @endif
                        <input type="file" class="form-control" id="in_route_photo" name="in_route_photo" accept="image/*">
                        <div class="form-text">Max 2MB. Solo visible para el departamento de Ruta.</div>
                    </div>

                    <div class="mb-3">
                        <label for="delivered_photo" class="form-label">Foto de Entrega (solo si el estado es 'Entregado'):</label>
                        @if ($order->delivered_photo_path)
                            <p>Foto actual: <a href="{{ Storage::url($order->delivered_photo_path) }}" target="_blank">Ver Foto</a></p>
                            <img src="{{ Storage::url($order->delivered_photo_path) }}" alt="Foto de Entrega Actual" class="img-fluid" style="max-height: 150px;">
                        @endif
                        <input type="file" class="form-control" id="delivered_photo" name="delivered_photo" accept="image/*">
                        <div class="form-text">Max 2MB.</div>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Orden</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
