<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\MembershipStatus;
use App\Models\Organization;
use App\Models\User;

use Illuminate\Http\Request;

class MembershipStatusController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
            try{
                $follow = MembershipStatus::create([
                    'id_user' => Auth::user()->id,
                    'id_organization' => $request->input('organization'),
                    'member_type' => 'asking'
                ]);

                $response = [
                    'success' => 1,
                    'status' => 'ask',
                ];
            
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function destroy(Request $request)
    {
        try{
            $status = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))->first()->member_type;
            $delete = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->delete();
    
            if(Organization::find($request->input('organization'))){
                $response = ['success' => 1,'status' => 'none', 'old_role' => $status];
                return response()->json($response);
            }
            $response = ['status' => 'none_org', 'old_role' => $status];
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function update(Request $request)
    {
        try{
            $update = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->update(['member_type' => 'member']);

            $response = [
                'success' => 1,
                'status' => 'member',
            ];
            
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function upgrade(Request $request){
        try{
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->first();
            $this->authorize('upgrade', $auth);  

            $update = MembershipStatus::where('id_user', $request->input('user'))
            ->where('id_organization', $request->input('organization'))
            ->update(['member_type' => 'leader']);

            $response = [
                'success' => 1,
                'action' => 'upgrade',
                'user' => $request->input('user')
            ];
        
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function expel(Request $request){
        $auth = MembershipStatus::where('id_user', Auth::user()->id)
        ->where('id_organization', $request->input('organization'))
        ->first();
        $this->authorize('expel', $auth);  

        try{
            $update = MembershipStatus::where('id_user', $request->input('user'))
            ->where('id_organization', $request->input('organization'))
            ->delete();
    
            $response = [
                'success' => 1,
                'action' => 'expel',
                'user' => $request->input('user')
            ];
        
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function decline(Request $request){
        try{
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->first();
            $this->authorize('decline', $auth);  

            $update = MembershipStatus::where('id_user', $request->input('user'))
            ->where('id_organization', $request->input('organization'))
            ->delete();

            $response = [
                'success' => 1,
                'action' => 'decline',
                'user' => $request->input('user')
            ];
        
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }

    public function accept(Request $request)
    {
        try{
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
            ->where('id_organization', $request->input('organization'))
            ->first();
            $this->authorize('accept', $auth);  

            $update = MembershipStatus::where('id_user', $request->input('user'))
                ->where('id_organization', $request->input('organization'))
                ->update(['member_type' => 'member']);

            $response = [
                'success' => 1,
                'action' => 'accept',
                'user' => $request->input('user'),
                'user_name' => User::find($request->input('user'))->name
            ];
            
            return response()->json($response);
        } catch (AuthorizationException $e) {
            return response()->json(['success' => 0]);
        }
    }
}
