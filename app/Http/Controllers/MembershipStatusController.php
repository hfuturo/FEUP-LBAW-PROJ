<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\MembershipStatus;
use App\Models\Organization;

use Illuminate\Http\Request;

class MembershipStatusController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $follow = MembershipStatus::create([
            'id_user' => Auth::user()->id,
            'id_organization' => $request->input('organization'),
            'member_type' => 'asking'
        ]);

        $response = [
            'status' => 'ask',
        ];
        
        return response()->json($response);
    }

    public function destroy(Request $request)
    {
        $delete = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->delete();

        if(Organization::find($request->input('organization'))){
            $response = ['status' => 'none'];
            return response()->json($response);
        }
        $response = ['status' => 'none_org'];
        return response()->json($response);
    }

    public function update(Request $request)
    {
        $update = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->update(['member_type' => 'member']);

        $response = [
            'status' => 'member',
        ];
        
        return response()->json($response);
    }

    public function upgrade(Request $request){
        $auth = MembershipStatus::where('id_user', Auth::user()->id)
        ->where('id_organization', $request->input('organization'))
        ->first();
        $this->authorize('upgrade', $auth);  

        $update = MembershipStatus::where('id_user', $request->input('user'))
        ->where('id_organization', $request->input('organization'))
        ->update(['member_type' => 'leader']);

        $response = [
            'action' => 'upgrade',
            'user' => $request->input('user')
        ];
    
        return response()->json($response);
    }

    public function expel(Request $request){
        $auth = MembershipStatus::where('id_user', Auth::user()->id)
        ->where('id_organization', $request->input('organization'))
        ->first();
        $this->authorize('expel', $auth);  

        $update = MembershipStatus::where('id_user', $request->input('user'))
        ->where('id_organization', $request->input('organization'))
        ->delete();

        $response = [
            'action' => 'expel',
            'user' => $request->input('user')
        ];
    
        return response()->json($response);
    }
}