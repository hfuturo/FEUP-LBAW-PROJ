<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class RecoverPasswordController extends Controller
{
    public function show_recover_password_form(User $user)
    {
        return view('auth.recover_password', ['email' => $user->email]);
    }

    public function verify_code_form(User $user)
    {
        return view('auth.verify_code', ['user' => $user]);
    }

    public function verify_code(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        $request->validate([
            'email' => 'required|email',
            'code' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($user === NULL) {
            return back()->withErrors(['email' => 'Invalid email']);
        }

        if ($user->recover_password_code !== intval($request->code)) {
            if ($user->recover_password_tries !== 0) {
                $user->recover_password_tries--;
                $user->save();
                return back()->withErrors(['code' => 'Wrong code. ' . ($user->recover_password_tries + 1)  . ' tentatives remaining.']);
            }
            User::where('email', '=', $request->email)->update([
                'recover_password_code' => null,
                'recover_password_tries' => null
            ]);
            return redirect()->route('recover_password')->withErrors(['error' => 'Run out of tries to reset password']);
        }

        User::where('email', '=', $request->email)->update([
            'password' => Hash::make($request->password),
            'recover_password_code' => null,
            'recover_password_tries' => null
        ]);

        Auth::loginUsingId($user->id, $request->filled('remember'));
        $request->session()->regenerate();
        return redirect()->route('news')->withSuccess('Password changed successfully!');
    }

    public function change_password_form(User $user)
    {
        return view('auth.change_password', ['email' => $user->email]);
    }
}
