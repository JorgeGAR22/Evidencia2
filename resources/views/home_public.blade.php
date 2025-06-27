<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Halcon - Seguimiento de Órdenes</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            margin-top: 50px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .status-badge {
            padding: 0.5em 0.8em;
            border-radius: 0.25rem;
            font-weight: bold;
            text-transform: capitalize;
        }
        .status-pending { background-color: #ffc107; color: #343a40; } /* Yellow */
        .status-in_process { background-color: #17a2b8; color: white; } /* Cyan */
        .status-in_route { background-color: #007bff; color: white; } /* Blue */
        .status-delivered { background-color: #28a745; color: white; } /* Green */
        .status-cancelled { background-color: #dc3545; color: white; } /* Red */
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h2>Seguimiento de Órdenes Halcon</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('public.search') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="invoice_number" class="form-label">Número de Factura:</label>
                                <!-- Mantener el valor de búsqueda después de enviar el formulario -->
                                <input type="text" class="form-control @error('invoice_number') is-invalid @enderror" id="invoice_number" name="invoice_number" value="{{ old('invoice_number', request('invoice_number')) }}" required>
                                @error('invoice_number')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Buscar Orden</button>
                        </form>

                        @if (isset($order))
                            <h4 class="mt-4">Detalles de la Orden:</h4>
                            @if ($order)
                                <ul class="list-group">
                                    <li class="list-group-item"><strong>Número de Factura:</strong> {{ $order->invoice_number }}</li>
                                    <li class="list-group-item"><strong>Nombre del Cliente:</strong> {{ $order->customer_name }}</li>
                                    <li class="list-group-item">
                                        <strong>Estado:</strong>
                                        <span class="status-badge status-{{ $order->status }}">{{ str_replace('_', ' ', $order->status) }}</span>
                                    </li>
                                    @if ($order->status === 'in_process' && $order->process_name)
                                        <li class="list-group-item"><strong>Proceso Actual:</strong> {{ $order->process_name }}</li>
                                        <li class="list-group-item"><strong>Fecha de Proceso:</strong> {{ $order->process_date ? $order->process_date->format('d/m/Y H:i') : 'N/A' }}</li>
                                    @endif
                                    @if ($order->status === 'delivered' && $deliveryPhotoUrl)
                                        <li class="list-group-item">
                                            <strong>Evidencia de Entrega:</strong><br>
                                            <!-- Usa asset() o la ruta directamente si storage:link funciona. Storage::url() requiere una ruta de almacenamiento correcta -->
                                            <img src="{{ $deliveryPhotoUrl }}" alt="Foto de Entrega" class="img-fluid mt-2" style="max-height: 300px;">
                                        </li>
                                    @endif
                                    <!-- Otros detalles que quieras mostrar públicamente -->
                                </ul>
                            @else
                                <div class="alert alert-warning mt-4" role="alert">
                                    Orden no encontrada. Por favor, verifica el n=C3=BAmero de factura.
                                </div>
                            @endif
                        @endif

                        {{-- Los errores de validación ahora se manejan directamente en el campo con @error --}}
                        {{-- @if ($errors->any())
                            <div class="alert alert-danger mt-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}

                        <div class="text-center mt-4">
                            <a href="{{ route('login') }}" class="btn btn-link">Acceso para Personal (Login)</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>