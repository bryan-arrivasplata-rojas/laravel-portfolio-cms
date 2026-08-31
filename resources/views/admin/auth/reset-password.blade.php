<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Contraseña · CMS Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        body { background-color: #0b1a2e; color: #e8edf5; min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .auth-card { background: #112b45; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; width: 100%; max-width: 420px; padding: 36px 32px; box-shadow: 0 20px 40px -12px rgba(0,0,0,0.6); }
        .auth-logo { text-align: center; font-family: 'Outfit', sans-serif; font-size: 2rem; font-weight: 700; margin-bottom: 24px; }
        .auth-logo span { color: #f0b429; }
        .auth-title { font-size: 1.25rem; font-weight: 600; margin-bottom: 8px; text-align: center; }
        .auth-sub { color: #9bb0c9; font-size: 0.875rem; text-align: center; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 0.85rem; font-weight: 500; color: #9bb0c9; margin-bottom: 6px; }
        .form-control { width: 100%; padding: 12px 14px; border-radius: 8px; background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #fff; font-size: 0.95rem; outline: none; }
        .form-control:focus { border-color: #f0b429; }
        .btn-submit { width: 100%; padding: 12px; border-radius: 8px; background: #f0b429; color: #0b1a2e; font-weight: 600; border: none; cursor: pointer; font-size: 1rem; margin-top: 10px; }
        .btn-submit:hover { background: #fad87a; }
        .alert { padding: 12px; border-radius: 8px; font-size: 0.85rem; margin-bottom: 20px; }
        .alert-error { background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #fca5a5; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">B<span>.</span>A<span>.</span></div>
        <h1 class="auth-title">Restablecer Contraseña</h1>
        <p class="auth-sub">Ingresa tu nueva clave de acceso</p>

        @if ($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label class="form-label" for="password">Nueva Contraseña</label>
                <input class="form-control" type="password" id="password" name="password" required autofocus placeholder="••••••••">
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Confirmar Nueva Contraseña</label>
                <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-check-circle"></i> Actualizar Contraseña
            </button>
        </form>
    </div>
</body>
</html>