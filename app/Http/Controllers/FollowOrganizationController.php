<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\FollowOrganization;

use Illuminate\Http\Request;

class FollowOrganizationController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $follow = FollowOrganization::create([
            'id_following' => Auth::user()->id,
            'id_organization' => $request->input('organization'),
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
        FollowOrganization::where('id_following', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))->first();

        $unfollow = FollowOrganization::where('id_following', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->delete();

        $response = [
            'follow' => 'follow',
            'data' => $unfollow,
        ];

        return response()->json($response);
    }
}
