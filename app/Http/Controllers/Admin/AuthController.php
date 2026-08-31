<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showLogin(Request $request)
    {
        // Si ya cuenta con sesión activa o token persistente "Remember", redirige directo al dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Recuperar correo recordado de la cookie segura (si existe)
        $rememberedEmail = $request->cookie('remember_admin_email', '');
        $isRemembered = !empty($rememberedEmail);

        return view('admin.auth.login', compact('rememberedEmail', 'isRemembered'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Si marcó "Recordar sesión", se almacena la cookie durante 30 días (43200 minutos)
            if ($remember) {
                Cookie::queue('remember_admin_email', $request->email, 43200);
            } else {
                Cookie::queue(Cookie::forget('remember_admin_email'));
            }

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas son incorrectas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function showForgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un formato válido de correo.',
            'email.exists' => 'No encontramos ningún usuario con ese correo electrónico.',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $resetUrl = route('admin.password.reset', ['token' => $token, 'email' => $request->email]);

        try {
            Mail::raw("Hola, solicitaste restablecer tu contraseña. Ingresa al siguiente enlace:\n\n{$resetUrl}\n\nSi no fuiste tú, puedes ignorar este mensaje.", function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Recuperación de Contraseña - CMS Portfolio');
            });
        } catch (\Exception $e) {
            logger()->info("Password reset link for {$request->email}: {$resetUrl}");
        }

        return back()->with('status', 'Hemos enviado el enlace de restablecimiento a tu correo electrónico.');
    }

    public function showResetPassword(Request $request, $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'El token de recuperación es inválido o ha expirado.']);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('admin.login')->with('status', 'Contraseña restablecida exitosamente. Ahora puedes iniciar sesión.');
    }
}