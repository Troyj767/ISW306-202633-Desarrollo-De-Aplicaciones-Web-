<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Login y cierre de sesión del panel (antes auth/login.php y auth/logout.php).
 * Laravel inyecta el objeto Request en cada método: no hay que leer $_POST.
 */
class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Completa el correo y la contraseña.',
            'email.email'       => 'Escribe un correo válido.',
            'password.required' => 'Completa el correo y la contraseña.',
        ]);

        // Auth::attempt busca el usuario y compara la contraseña con el hash (como password_verify)
        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate(); // nuevo ID de sesión (igual que session_regenerate_id)

            return redirect()->intended(route('admin.panel'));
        }

        return back()
            ->withErrors(['email' => 'Correo o contraseña incorrectos.'])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();      // borra los datos de la sesión
        $request->session()->regenerateToken(); // nuevo token CSRF

        return redirect()->route('login');
    }
}
