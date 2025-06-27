@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Crear Nueva Orden</div>

            <div class="card-body">
                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="invoice_number" class="form-label">Número de Factura:</label>
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nombre del Cliente / Empresa:</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email del Cliente (opcional):</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" value="{{ old('customer_email') }}">
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Teléfono del Cliente (opcional):</label>
                        <input type="text" class="form-control" id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}">
                    </div>
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Dirección de Entrega:</label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required>{{ old('shipping_address') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Monto Total:</label>
                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Orden Creada Por (Vendedor):</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', Auth::id()) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Orden</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
