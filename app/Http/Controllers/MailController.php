<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MailController extends Controller
{
    function send(Request $request) {
        $user = User::where('email', '=', $request->email)->first();

        if ($user === NULL) {
            return redirect()->route('login')->withErrors(['error', 'Invalid email']);
        }
                
        $mailData = [
            'name' => $user->name,
            'email' => $request->email,
            'code' => random_int(100000, 999999),
        ];

        Mail::to($request->email)->send(new MailModel($mailData));
        return redirect()->route('news');
    }
}
