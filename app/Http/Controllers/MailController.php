<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Mail;
use App\Mail\MailModel;

class MailController extends Controller
{
    function send_recover_password_mail(Request $request)
    {
        $user = User::where('email', '=', $request->email)->first();

        if ($user === NULL) {
            return back()->withErrors(['Invalid email']);
        }

        $mailData = [
            'name' => $user->name,
            'email' => $request->email,
            'subject' => 'Recover Password',
            'view' => 'emails.recover_password',
            'code' => random_int(100000, 999999),
        ];

        Mail::to($request->email)->send(new MailModel($mailData));
        User::where('email', '=', $request->email)->update(['recover_password_code' => $mailData['code'], 'recover_password_tries' => 5]);

        return redirect()->route('verify_code_form', ['user' => $user->id])->withSuccess('An email was sent with the verification code.');
    }

    public static function send_blocked_unblocked_account_email(User $user, bool $blocked)
    {
        $mailData = [
            'name' => $user->name,
            'email' => $user->email,
            'subject' => $blocked ? 'Your account has been blocked' : 'Your account has been unblocked',
            'view' => $blocked ? 'emails.account_blocked' : 'emails.account_unblocked',
        ];

        Mail::to($user->email)->send(new MailModel($mailData));
    }
}
