<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowUser;
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
        if ($request->input('id_following') == null) {
            return redirect()->route('profile', [Auth::user()->id]);
        }
        try {
            FollowUser::create([
                'id_follower' => Auth::user()->id,
                'id_following' => $request->input('id_following'),
            ]);
        } catch (Exception $e) {
        }
        return redirect()->route('profile', [$request->input('id_following')]);
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
        if ($request->input('id_following') == null) {
            return redirect()->route('profile', [Auth::user()->id]);
        }

        try {
            FollowUser::where('id_follower', Auth::user()->id)
                ->where('id_following', $request->input('id_following'))
                ->delete();
        } catch (Exception $e) {
        }
        return redirect()->route('profile', [$request->input('id_following')]);
    }
}
