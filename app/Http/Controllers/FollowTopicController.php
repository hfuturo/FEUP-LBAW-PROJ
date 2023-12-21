<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowTopic;
use Illuminate\Http\Request;

class FollowTopicController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $follow = FollowTopic::create([
            'id_following' => Auth::user()->id,
            'id_topic' => $request->input('topic'),
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
        $followTopic = FollowTopic::where('id_following', Auth::user()->id)->where('id_topic', $request->input('topic'))->first();
        $this->authorize('destroy', $followTopic);

        $unfollow = FollowTopic::where('id_following', Auth::user()->id)->where('id_topic', $request->input('topic'))
            ->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];

        return response()->json($response);
    }
}
