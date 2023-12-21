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
        try {
            MembershipStatus::create([
                'id_user' => Auth::user()->id,
                'id_organization' => $request->input('organization'),
                'member_type' => 'asking'
            ]);

            $response = [
                'success' => 1,
                'status' => 'ask',
            ];

            return response()->json($response);
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'message' => 'Try to refresh the page or check if you have the right permissions to perform this action']);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $membershipStatus = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->first();

            if ($membershipStatus) {
                $status = $membershipStatus->member_type;
                MembershipStatus::where('id_user', Auth::user()->id)
                    ->where('id_organization', $request->input('organization'))
                    ->delete();

                if (Organization::find($request->input('organization'))) {
                    $response = ['success' => 1, 'status' => 'none', 'old_role' => $status];
                    return response()->json($response);
                }

                $response = ['success' => 1, 'status' => 'none_org', 'old_role' => $status];
                return response()->json($response);
            } else {
                return response()->json(['success' => 0, 'message' => "Your request was already decline by the organization, you can refresh the page to see the changes."]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'message' => "Try to refresh the page or check if you have the right permissions to perform this action"]);
        }
    }

    public function upgrade(Request $request)
    {
        try {
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->first();
            if ($auth) {
                $this->authorize('upgrade', $auth);
            } else {
                $auth = new MembershipStatus();
                $this->authorize('upgrade', $auth);
            }
            $membershipStatus = MembershipStatus::where('id_user', $request->input('user'))
                ->where('id_organization', $request->input('organization'));

            if ($membershipStatus) {
                $membershipStatus->update(['member_type' => 'leader']);

                $response = [
                    'success' => 1,
                    'action' => 'upgrade',
                    'user' => $request->input('user')
                ];

                return response()->json($response);
            } else {
                return response()->json(['success' => 0, 'message' => "This user left the organization recently, you can refresh the page to see the changes."]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 0,  'message' => "Try to refresh the page or check if you have the right permissions to perform this action"]);
        }
    }

    public function expel(Request $request)
    {
        try {
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->first();
            if ($auth) {
                $this->authorize('expel', $auth);
            } else {
                $auth = new MembershipStatus();
                $this->authorize('expel', $auth);
            }
            $membershipStatus = MembershipStatus::where('id_user', $request->input('user'))
                ->where('id_organization', $request->input('organization'));
            if ($membershipStatus) {
                $membershipStatus->delete();

                $response = [
                    'success' => 1,
                    'action' => 'expel',
                    'user' => $request->input('user')
                ];

                return response()->json($response);
            } else {
                return response()->json(['success' => 0, 'message' => "This user left the organization recently, you can refresh the page to see the changes."]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'message' => "Try to refresh the page or check if you have the right permissions to perform this action"]);
        }
    }

    public function decline(Request $request)
    {
        try {
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->first();
            if ($auth) {
                $this->authorize('decline', $auth);
            } else {
                $auth = new MembershipStatus();
                $this->authorize('decline', $auth);
            }
            $membershipStatus = MembershipStatus::where('id_user', $request->input('user'))
                ->where('id_organization', $request->input('organization'));

            if ($membershipStatus) {
                $membershipStatus->delete();

                $response = [
                    'success' => 1,
                    'action' => 'decline',
                    'user' => $request->input('user')
                ];
                return response()->json($response);
            } else {
                return response()->json(['success' => 0, 'message' => "This user is no longer interested in becoming part of this organization, you can refresh the page to see the changes."]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'message' => "Try to refresh the page or check if you have the right permissions to perform this action"]);
        }
    }

    public function accept(Request $request)
    {
        try {
            $auth = MembershipStatus::where('id_user', Auth::user()->id)
                ->where('id_organization', $request->input('organization'))
                ->first();
            if ($auth) {
                $this->authorize('accept', $auth);
            } else {
                $auth = new MembershipStatus();
                $this->authorize('accept', $auth);
            }
            $membershipStatus = MembershipStatus::where('id_user', $request->input('user'))
                ->where('id_organization', $request->input('organization'));

            if ($membershipStatus) {
                $membershipStatus->update(['member_type' => 'member']);
                $response = [
                    'success' => 1,
                    'action' => 'accept',
                    'user' => $request->input('user'),
                    'user_name' => User::find($request->input('user'))->name
                ];

                return response()->json($response);
            } else {
                return response()->json(['success' => 0, 'message' => "This user is no longer interested in becoming part of this organization, you can refresh the page to see the changes."]);
            }
        } catch (Exception $e) {
            return response()->json(['success' => 0, 'message' => "Try to refresh the page or check if you have the right permissions to perform this action"]);
        }
    }
}
