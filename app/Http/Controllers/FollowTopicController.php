<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowTopic;
use Illuminate\Http\Request;

class FollowTopicController extends Controller
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
        $unfollow = FollowTopic::where('id_following', Auth::user()->id)
            ->where('id_topic', $request->input('topic'))
            ->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];
        
        return response()->json($response);
    }
}
