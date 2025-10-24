<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

/**
 * Controlador de autenticación
 * 
 * Maneja todas las operaciones relacionadas con autenticación de usuarios,
 * incluyendo login, logout, registro y gestión de perfil.
 */
class AuthController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * Procesa el inicio de sesión del usuario
     * 
     * @throws ValidationException
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Por favor ingrese su correo electrónico.',
            'email.email' => 'El correo electrónico no es válido.',
            'password.required' => 'Debe ingresar una contraseña.',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'email' => ['El correo electrónico no está registrado.']
                ]
            ], 422);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'status' => 'error',
                'errors' => [
                    'password' => ['La contraseña es incorrecta.']
                ]
            ], 422);
        }

        Auth::login($user);

        $this->createUserSession($request, $user);

        return response()->json([
            'status' => 'success',
            'redirect' => url('/inicio')
        ]);
    }

    /**
     * Cierra la sesión del usuario completamente
     * 
     * Actualiza el registro de sesión en BD, invalida la sesión de Laravel
     * y redirige al usuario a la página principal
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->closeUserSession();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Muestra el formulario de registro
     */
    public function showRegister(): View
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro de un nuevo usuario
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'password' => ['required', 'confirmed', 'min:6'],
        ], [
            'nombre.required' => 'El nombre es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es requerida.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        $user = User::create([
            'nombre' => $validated['nombre'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        $this->createUserSession($request, $user);

        return redirect('/')->with('success', 'Cuenta creada exitosamente.');
    }

    /**
     * Muestra el perfil del usuario autenticado
     */
    public function showProfile(): View
    {
        return view('auth.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Actualiza el perfil del usuario
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:usuarios,email,' . $user->id],
        ], [
            'nombre.required' => 'El nombre es requerido.',
            'email.required' => 'El correo electrónico es requerido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
        ]);

        $user->fill($validated);
        $user->save();

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Cambia la contraseña del usuario
     */
    public function changePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', 'min:6', 'different:current_password'],
        ], [
            'current_password.required' => 'Debe ingresar su contraseña actual.',
            'password.required' => 'La nueva contraseña es requerida.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'password.different' => 'La nueva contraseña debe ser diferente a la actual.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'La contraseña actual es incorrecta.'
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Muestra el historial de sesiones del usuario
     */
    public function showSessions(): View
    {
        $sessions = UserSession::where('user_id', Auth::id())
            ->orderByDesc('login_at')
            ->paginate(15);

        return view('auth.sessions', compact('sessions'));
    }

    /**
     * Crea un registro de sesión en la base de datos
     * 
     * Método auxiliar que guarda los datos de inicio de sesión
     * en la tabla UserSession para mantener un historial
     */
    private function createUserSession(Request $request, User $user): void
    {
        $session = UserSession::create([
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'login_at' => now(),
        ]);

        session(['custom_session_id' => $session->id]);
    }

    /**
     * Actualiza el registro de sesión en la base de datos
     * 
     * Método auxiliar que guarda la hora de cierre y duración
     * en la tabla UserSession para mantener un historial
     */
    private function closeUserSession(): void
    {
        if (!session()->has('custom_session_id')) {
            return;
        }

        $session = UserSession::find(session('custom_session_id'));

        if (!$session) {
            return;
        }

        $session->logout_at = now();
        $session->duration_seconds = now()->diffInSeconds($session->login_at);
        $session->save();
    }
}
