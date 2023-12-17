<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowUser;
use App\Models\Notification;
use App\Models\Notified;
use App\Events\SendNotification;

use Exception;
use Illuminate\Http\Request;

class FollowUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

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

        /*
        $notification_id = Notification::where('id_user','=',Auth::user()->id)->first();
        $notfied_id = Notified::where('id_notification','=',$notification_id)->where('id_notified','=',$request->input('user'))->first();
        event(new SendNotification($notfied_id,"You are being Followed"));
        */
        $response = [
            'follow' => 'unfollow',
            'data' => $follow,
        ];
        
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(FollowUser $follow_User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FollowUser $follow_User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FollowUser $follow_User)
    {
        //
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
