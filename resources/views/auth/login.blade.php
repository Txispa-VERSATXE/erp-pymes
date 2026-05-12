<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP PYMES — Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f4f0;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 14px;
            border: 1px solid rgba(0,0,0,0.08);
            padding: 40px;
            width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }
        .login-logo {
            margin-bottom: 20px;
        }
        .login-logo img {
            height: 52px;
            width: auto;
        }
        .btn-primary {
            background: #1a3a5c;
            border-color: #1a3a5c;
        }
        .btn-primary:hover {
            background: #122e4a;
            border-color: #122e4a;
        }
        .form-control:focus {
            border-color: #2563a8;
            box-shadow: 0 0 0 3px rgba(37,99,168,0.1);
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('images/wildstack.png') }}" alt="WildStack">
        </div>
        <h1 style="font-size:22px;font-weight:700;letter-spacing:-0.3px;">Bienvenido</h1>
        <p style="font-size:13px;color:#6b6a66;margin-bottom:28px;">Inicia sesión en tu sistema de gestión</p>

        @if($errors->any())
            <div class="alert alert-danger" style="font-size:13px;">
                <i class="bi bi-exclamation-circle me-2"></i>{{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="usuario@empresa.com" required>
            </div>
            <div class="mb-4">
                <label class="form-label" style="font-size:12px;font-weight:600;color:#6b6a66;">Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="padding:10px;">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
            </button>
        </form>

        <div style="margin-top:20px;padding:12px;background:#f5f4f0;border-radius:8px;font-size:12px;color:#6b6a66;">
            <strong>Admin:</strong> admin@erp.com / admin123<br>
            <strong>Empleado Prueba:</strong> empleado@erp.com / emp123
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>