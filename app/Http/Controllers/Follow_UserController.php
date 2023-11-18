<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\Models\Follow_User;
use Illuminate\Http\Request;

class Follow_UserController extends Controller
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
    public function create($id_follower,$id_following)
    {
        Follow_User::create([
            'id_follower' => $id_follower,
            'id_following' => $id_following,
        ]);
        return redirect()->route('profile',[$id_following]);
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
    public function show(Follow_User $follow_User)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Follow_User $follow_User)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Follow_User $follow_User)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_follower, $id_following)
    {
        Follow_User::where('id_follower', $id_follower)
               ->where('id_following', $id_following)
               ->delete();

        return redirect()->route('profile',[$id_following]);
    }
}
