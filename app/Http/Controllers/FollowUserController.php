<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowUser;
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

        $response = [
            'follow' => 'follow',
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

        $unfollow = FollowUser::where('id_follower', Auth::user()->id)
            ->where('id_following', $request->input('user'))
            ->delete();

        $response = [
            'follow' => 'unfollow',
            'data' => $unfollow,
        ];
        
        return response()->json($response);
    }
}
