<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Arial', sans-serif;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .jumbotron {
            background-color: #e9ecef;
            padding: 60px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 40px;
        }
        .section-content {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 50px;
            padding: 20px;
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Activity 9</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4">¡Bienvenido a la Página de Inicio (Landing Page)!</h1>
            <p class="lead">Esta vista es para usuarios no registrados.</p>
            <hr class="my-4">
            <p>Por favor, inicia sesión o regístrate para acceder al Dashboard.</p>
            <a class="btn btn-primary btn-lg" href="{{ route('login') }}" role="button">Iniciar Sesión</a>
            <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Registrarse</a>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="section-content">
                    <h3>Sobre Nosotros</h3>
                    <p>Aquí puedes encontrar información general sobre nuestro proyecto. Nuestro objetivo es ayudarte a organizar tus datos de manera segura.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="section-content">
                    <h3>Características</h3>
                    <ul>
                        <li>Acceso seguro para usuarios registrados.</li>
                        <li>Panel de control personalizable.</li>
                        <li>¡Y mucho más por venir!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <span>&copy; 2025 Activity 9. Todos los derechos reservados.</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
