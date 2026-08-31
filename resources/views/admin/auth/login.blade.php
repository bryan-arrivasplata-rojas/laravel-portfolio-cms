<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión · CMS Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body {
            background-color: #0b1a2e;
            color: #e8edf5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: #112b45;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            padding: 36px 32px;
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.6);
        }
        .auth-logo {
            text-align: center;
            font-family: 'Outfit', sans-serif;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 24px;
        }
        .auth-logo span { color: #f0b429; }
        .auth-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 8px;
            text-align: center;
        }
        .auth-sub {
            color: #9bb0c9;
            font-size: 0.875rem;
            text-align: center;
            margin-bottom: 24px;
        }
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #9bb0c9;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-control:focus {
            border-color: #f0b429;
            box-shadow: 0 0 0 2px rgba(240, 180, 41, 0.2);
        }
        .form-extra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            margin-bottom: 24px;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #9bb0c9;
            cursor: pointer;
            user-select: none;
        }
        .form-check input {
            accent-color: #f0b429;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }
        .auth-link { color: #f0b429; text-decoration: none; font-weight: 500; }
        .auth-link:hover { text-decoration: underline; }
        .btn-submit {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            background: #f0b429;
            color: #0b1a2e;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s, transform 0.1s;
        }
        .btn-submit:hover { background: #fad87a; }
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 0.88rem;
            margin-bottom: 20px;
        }
        .alert-error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid #ef4444;
            color: #fca5a5;
        }
        .alert-success {
            background: rgba(34, 197, 94, 0.15);
            border: 1px solid #22c55e;
            color: #86efac;
        }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">B<span>.</span>A<span>.</span></div>
        <h1 class="auth-title">Acceso Administrativo</h1>
        <p class="auth-sub">Ingresa tus credenciales para gestionar el contenido</p>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle" style="margin-right: 6px;"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" autocomplete="on">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Correo Electrónico</label>
                <input 
                    class="form-control" 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="{{ old('email', $rememberedEmail ?? '') }}" 
                    required 
                    autofocus 
                    autocomplete="username"
                    placeholder="admin@ejemplo.com"
                >
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Contraseña</label>
                <input 
                    class="form-control" 
                    type="password" 
                    id="password" 
                    name="password" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
            </div>

            <div class="form-extra">
                <label class="form-check" for="remember">
                    <input 
                        type="checkbox" 
                        name="remember" 
                        id="remember" 
                        value="1" 
                        {{ old('remember', !empty($rememberedEmail)) ? 'checked' : '' }}
                    > 
                    <span>Recordar sesión</span>
                </label>
                <a class="auth-link" href="{{ route('admin.password.request') }}">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
            </button>
        </form>
    </div>
</body>
</html>