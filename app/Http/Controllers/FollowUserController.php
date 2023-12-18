<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowUser;
use App\Models\Notification;

use App\Events\FollowUserNotification;

use Illuminate\Http\Request;

class FollowUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if ($request->input('user') == null) {
            return redirect()->route('profile', [Auth::user()->id]);
        }
        $follow = FollowUser::create([
            'id_follower' => Auth::user()->id,
            'id_following' => $request->input('user'),
        ]);

        $notification_id = Notification::where('id_user', '=', Auth::user()->id)->orderBy('id', 'DESC')->first();

        event(new FollowUserNotification($request->input('user'), Auth::user()->id, Auth::user()->name, $notification_id->id));

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
        if ($request->input('user') == null) {
            return redirect()->route('profile', [Auth::user()->id]);
        }

        $followUser = FollowUser::where('id_follower', Auth::user()->id)
            ->where('id_following', $request->input('user'))->first();
        $this->authorize('destroy', $followUser);


        $unfollow = FollowUser::where('id_follower', Auth::user()->id)
            ->where('id_following', $request->input('user'))
            ->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];

        return response()->json($response);
    }
}
