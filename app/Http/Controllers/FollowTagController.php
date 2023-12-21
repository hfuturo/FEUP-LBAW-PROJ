<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowTag;
use Illuminate\Http\Request;

class FollowTagController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $follow = FollowTag::create([
            'id_following' => Auth::user()->id,
            'id_tag' => $request->input('tag'),
        ]);

        $response = [
            'follow' => 'unfollow',
            'data' => $follow,
        ];
        
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $followTag = FollowTag::where('id_following', Auth::user()->id)->where('id_tag', $request->input('tag'))->first();
        $this->authorize('destroy', $followTag);
        $unfollow = FollowTag::where('id_following', Auth::user()->id)->where('id_tag', $request->input('tag'))->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];
        
        return response()->json($response);
    }
}
