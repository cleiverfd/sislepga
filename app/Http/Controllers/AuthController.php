<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function guest()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validación inicial
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Por favor ingrese su correo electrónico.',
            'email.email'    => 'El correo electrónico no es válido.',
            'password.required' => 'Debe ingresar una contraseña.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'email' => ['El correo electrónico no está registrado.']
                ]
            ], 422);
        }

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'password' => ['La contraseña es incorrecta.']
                ]
            ], 422);
        }

        Auth::login($user);

        // Guardar sesión
        $session = UserSession::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'login_at' => now(),
        ]);

        session(['custom_session_id' => $session->id]);

        return response()->json([
            'status' => 'success',
            'redirect' => url('/inicio')
        ]);
    }

    public function logout(Request $request)
    {
        if (session()->has('custom_session_id')) {
            $session = UserSession::find(session('custom_session_id'));
            if ($session) {
                $session->logout_at = now();
                $session->duration_seconds = now()->diffInSeconds($session->login_at);
                $session->save();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    // 4. Mostrar registro
    public function showRegister()
    {
        return view('auth.register');
    }

    // 5. Registro de usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    // 6. Mostrar perfil
    public function showProfile()
    {
        return view('auth.profile', [
            'user' => Auth::user()
        ]);
    }

    // 7. Actualizar perfil
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        //$user->update($request->only('name', 'email'));

        return back()->with('success', 'Perfil actualizado.');
    }

    // 8. Cambiar contraseña
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        if (! Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Contraseña actual incorrecta']);
        }

        // $user->update([
        //     'password' => Hash::make($request->password)
        // ]);

        return back()->with('success', 'Contraseña actualizada.');
    }

    // 9. Ver sesiones del usuario
    public function showSessions()
    {
        $sessions = UserSession::where('user_id', Auth::id())
            ->orderByDesc('login_at')
            ->get();

        return view('auth.sessions', compact('sessions'));
    }
}
