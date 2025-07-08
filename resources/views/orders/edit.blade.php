@extends('adminlte::page')

@section('title', 'Editar Orden')

@section('content_header')
    <h1>Editar Orden: #{{ $order->invoice_number }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Formulario de Edición de Orden</h3>
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

            <form action="{{ route('orders.update', $order) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="invoice_number">Número de Factura:</label>
                    <input type="text" name="invoice_number" id="invoice_number" class="form-control @error('invoice_number') is-invalid @enderror" value="{{ old('invoice_number', $order->invoice_number) }}" required>
                    @error('invoice_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_name">Nombre o Razón Social del Cliente:</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name', $order->customer_name) }}" required>
                    @error('customer_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_email">Email del Cliente (Opcional):</label>
                    <input type="email" name="customer_email" id="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email', $order->customer_email) }}">
                    @error('customer_email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="customer_phone">Teléfono del Cliente (Opcional):</label>
                    <input type="text" name="customer_phone" id="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone', $order->customer_phone) }}">
                    @error('customer_phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="shipping_address">Dirección de Entrega:</label>
                    <textarea name="shipping_address" id="shipping_address" class="form-control @error('shipping_address') is-invalid @enderror" rows="3" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                    @error('shipping_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="total_amount">Monto Total:</label>
                    <input type="number" step="0.01" name="total_amount" id="total_amount" class="form-control @error('total_amount') is-invalid @enderror" value="{{ old('total_amount', $order->total_amount) }}" required>
                    @error('total_amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="user_id">Vendedor (Creador de la Orden):</label>
                    <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror" required>
                        <option value="">Seleccione un vendedor</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $order->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status">Estado de la Orden:</label>
                    <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="">Seleccione un estado</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status }}" {{ old('status', $order->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="process_name">Nombre del Proceso (si aplica):</label>
                    <input type="text" name="process_name" id="process_name" class="form-control @error('process_name') is-invalid @enderror" value="{{ old('process_name', $order->process_name) }}">
                    @error('process_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="process_date">Fecha del Proceso (si aplica):</label>
                    <input type="datetime-local" name="process_date" id="process_date" class="form-control @error('process_date') is-invalid @enderror" value="{{ old('process_date', $order->process_date ? $order->process_date->format('Y-m-d\TH:i') : '') }}">
                    @error('process_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Campos de carga de fotos - VISIBLES SOLO PARA EL DEPARTAMENTO DE RUTA -->
                @if(Auth::check() && Auth::user()->hasDepartment('Ruta'))
                    <div class="form-group">
                        <label for="in_route_photo">Foto en Ruta (solo si el estado es 'En Ruta'):</label>
                        @if ($order->in_route_photo_path)
                            <p>Foto actual: <a href="{{ Storage::url($order->in_route_photo_path) }}" target="_blank">Ver Foto</a></p>
                            <img src="{{ Storage::url($order->in_route_photo_path) }}" alt="Foto en Ruta Actual" class="img-fluid" style="max-height: 150px;">
                        @endif
                        <input type="file" name="in_route_photo" id="in_route_photo" class="form-control-file @error('in_route_photo') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">Max 2MB.</small>
                        @error('in_route_photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="delivered_photo">Foto de Entrega (solo si el estado es 'Entregado'):</label>
                        @if ($order->delivered_photo_path)
                            <p>Foto actual: <a href="{{ Storage::url($order->delivered_photo_path) }}" target="_blank">Ver Foto</a></p>
                            <img src="{{ Storage::url($order->delivered_photo_path) }}" alt="Foto de Entrega Actual" class="img-fluid" style="max-height: 150px;">
                        @endif
                        <input type="file" name="delivered_photo" id="delivered_photo" class="form-control-file @error('delivered_photo') is-invalid @enderror" accept="image/*">
                        <small class="form-text text-muted">Max 2MB.</small>
                        @error('delivered_photo')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @else
                    <div class="alert alert-info" role="alert">
                        Solo el personal del departamento de Ruta puede cargar fotos de evidencia.
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Actualizar Orden</button>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
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
