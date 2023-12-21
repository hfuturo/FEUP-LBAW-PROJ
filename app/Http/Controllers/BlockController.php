<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\MailController;
use App\Models\User;

class BlockController extends Controller
{
    public function appeal_unblock(Request $request)
    {
        $this->authorize('appeal_unblock', \App\Block::class);

        Auth::user()->update(['blocked_appeal' => $request->input('text')]);

        return back()->with('success', 'Unblock appeal updated successfully');
    }

    public function reject_appeal(Request $request)
    {
        $user = User::find($request->input("request"));
        $this->authorize('reject_appeal', \App\Block::class);
        MailController::send_account_banned_email($user);
        $user->update(['appeal_rejected' => true]);
        $response = [
            'appeal_rejected' => $user->appeal_rejected,
        ];
        return response()->json($response);
    }
}
