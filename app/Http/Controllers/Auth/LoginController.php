<?php
 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\View\View;

use App\Models\User;

class LoginController extends Controller
{

    /**
     * Display a login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect('/news');
        } else {
            return view('auth.login');
        }
    }

    /**
     * Handle an authentication attempt.
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/news');
        }
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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

    public function show_recover_password_form() {
        return view('auth.recover_password');
    }

    public function verify_code(Request $request) {
        $user = User::where('email', '=', $request->email)->first();

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required'],
        ]);

        if ($user === NULL) {
            return back()->withErrors(['email' => 'Invalid email']);
        }

        if ($user->recover_password_code !== intval($request->code)) {
            return back()->withErrors(['code' => 'Wrong code.'])->onlyInput('email');
        }

        return view('auth.change_password', ['email' => $request->email]);
    }

    public function change_password(Request $request) {

        $credentials = $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:8|confirmed'
        ]);

        User::where('email', '=', $request->email)->update(['password' => Hash::make($request->password)]);

        return redirect()->route('login')->withSuccess('Password changed successfully');
    } 
}
