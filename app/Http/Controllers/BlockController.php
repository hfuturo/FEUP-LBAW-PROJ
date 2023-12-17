<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class BlockController extends Controller
{
    public function blockPage()
    {
        $this->authorize('blockPage', \App\Block::class);
        return view('pages.block');
    }

    public function appeal_unblock(Request $request)
    {
        $this->authorize('appeal_unblock', \App\Block::class);

        Auth::user()->update(['blocked_appeal' => $request->input('text')]);

        return back()->with('success', 'Unblock appeal updated successfully');
    }
}
