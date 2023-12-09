<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowTag;
use Illuminate\Http\Request;

class FollowTagController extends Controller
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
        $unfollow = FollowTag::where('id_following', Auth::user()->id)
            ->where('id_tag', $request->input('tag'))
            ->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];
        
        return response()->json($response);
    }
}
