<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\MailController;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
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
    public function create()
    {
        //
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
    public function show(User $user)
    {
        if (!Auth::check()) {
            return redirect('/login');
        } else {
            return view('pages.profile', ['user' => $user]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', \App\User::class);

        if ($user->email !== $request->input('email')) {
            $validator_unique = $request->validate(['email' => 'unique:authenticated_user']);
            if (!$validator_unique) {
                return back()->withErrors(['error', 'The email inserted is already being used!']);;
            }
        }
        $validator = $request->validate([
            'name' => 'string|max:250',
            'email' => 'email|max:250',
            'bio' => 'nullable|string'
        ]);
        if ($validator) {
            $user->name = empty($request->input('name')) ? $user->name : $request->input('name');
            $user->email = empty($request->input('email')) ? $user->email : $request->input('email');
            $user->bio = empty($request->input('bio')) ? '' : $request->input('bio');
            $user->save();
            return redirect()->route('profile', [$user])
                ->with('success', 'Successfully changed!');
        } else {
            if (empty($request->input('name'))){
                return back()->withErrors(['name' => 'Name field is mandatory']);
            } 
            else if (empty($request->input('email'))){
                return back()->withErrors(['email' => 'Email field is mandatory']);
            }
            return redirect()->route('profile', [$user])->withErrors(['error' => 'The parameters are invalid!']);
        }
    }

    public function block(Request $request)
    {
        $user = User::find($request->input("request"));
        $this->authorize('block', $user);
        $user->update(['blocked' => true]);
        $response = [
            'action' => 'block_user',
            'id' => $request->input("request"),
        ];
        MailController::send_blocked_unblocked_account_email($user, true);
        return response()->json($response);
    }

    public function block_perfil_button(User $user)
    {
        $this->authorize('block', $user);
        $user->update(['blocked' => true]);
        MailController::send_blocked_unblocked_account_email($user, true);
        return back()->with('success', 'Account blocked successfully!');
    }

    public function unblock(Request $request)
    {
        $user = User::find($request->input("request"));
        $this->authorize('unblock', \App\User::class);
        $user->update(['blocked' => false, 'blocked_appeal' => '', 'appeal_rejected' => false]);
        $response = [
            'action' => 'unblock_user',
            'id' => $request->input("request"),
        ];
        MailController::send_blocked_unblocked_account_email($user, false);
        return response()->json($response);
    }

    public function unblock_perfil_button(User $user)
    {
        $this->authorize('unblock', \App\User::class);
        $user->update(['blocked' => false, 'blocked_appeal' => '', 'appeal_rejected' => false]);
        MailController::send_blocked_unblocked_account_email($user, false);
        return back()->with('success', 'Account unblocked successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(User $user)
    {
        $this->authorize('delete', $user);
        return $user->delete() ?
            redirect()->route('news')->with('success', 'Account deleted successfully!') :
            redirect()->route('profile', [$user->id])->withErrors(['error' =>'Error deleting account!']);
    }

    public function destroy(Request $request)
    {
        $delete = User::where('id', $request->input("request"))
            ->delete();
        $response = [
            'action' => 'delete_user',
            'id' => $request->input("request"),
        ];
        return response()->json($response);
    }

    public function fetch_pfp(Request $request)
    {
        $user = User::findOrFail($request->id);
        return response()->json(['image' => $user->getProfileImage()]);
    }

    public function revoke_moderator(Request $request)
    {
        try {
            $this->authorize('change_moderator', User::class);

            $request->validate([
                'id' => 'integer|required'
            ]);

            $user = User::findOrFail($request->input('id'));
            $user->type = 'authenticated';
            $user->id_topic = NULL;
            $user->save();

            return response()->json(['success' => "Revoked moderator"]);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function make_moderator(Request $request)
    {
        try {
            $this->authorize('change_moderator', User::class);

            $request->validate([
                'user' => 'integer|required',
                'topic' => 'integer|required'
            ]);

            $user = User::findOrFail($request->input('user'));
            $topic = Topic::findOrFail($request->input('topic'));
            $user->id_topic = $topic->id;
            $user->type = "moderator";
            $user->save();

            return response()->json(['success' => $user->name . " is now a moderator",]);
        } catch (AuthorizationException $e) {
            return response()->json(['error' => $e->getMessage()], 403);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    public function upgrade(Request $request)
    {
        $user = User::find($request->input("idUser"));
        $this->authorize('upgrade', $user);
        $user->update(['id_topic' => null]);
        $user->type = 'admin';
        $user->save();
        return response()->json(['success' => 'admin', 'id' => $user->id]);
    }
}
