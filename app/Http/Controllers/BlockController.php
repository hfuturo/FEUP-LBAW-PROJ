<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $request->validate([
            'text' => 'required',
        ]);

        Auth::user()->update(['blocked_appeal' => $request->input('text')]);

        return back()->withSuccess(['Apeal updated successfully']);
    }
}
