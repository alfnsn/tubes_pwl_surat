<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => ['required', 'string'], // Changed 'email' to 'login'
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('password');
        $login = $request->input('login');

        // Check if the login input is an email or id
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'id';
        $credentials[$fieldType] = $login;

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();
        $user = Auth::user();
        switch ($user->role_id) {
            case 1:
                return redirect()->route('Mahasiswa.dashboard');
            case 2:
                return redirect()->route('Kaprodi.dashboard');
            case 3:
                return redirect()->route('MO.dashboard');
            case 4:
                return redirect()->route('Admin.dashboard');
            default:
                return redirect()->route('login'); 
        }

    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
