<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Mail;
use App\Mail\MailModel;

class MailController extends Controller
{
    function send(Request $request) {
        $user = User::where('email', '=', $request->email)->first();

        if ($user === NULL) {
           return back()->withErrors(['Invalid email']);
        }
        
        $mailData = [
            'name' => $user->name,
            'email' => $request->email,
            'code' => random_int(100000, 999999),
        ];

        Mail::to($request->email)->send(new MailModel($mailData));
        User::where('email', '=', $request->email)->update(['recover_password_code' => $mailData['code']]);

        return redirect()->route('verify_code_form', [$request->email]);
    }
}
