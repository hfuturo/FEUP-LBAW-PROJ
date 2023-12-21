<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            if ($user->blocked)
                return redirect()->route('blocked')->with(['user' => $user]);
            $request->session()->regenerate();
            return redirect()->intended('/news');
        }
        return back()->withErrors([
            'error' => 'Invalid credentials',
        ]);
    }

    /**
     * Log out the user from application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');
    }
}
