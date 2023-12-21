<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;

use App\Http\Controllers\MailController;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('pages.profile', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', \App\User::class);

        if ($user->email !== $request->input('email')) {
            $request->validate(['email' => 'unique:authenticated_user']);
        }
        $request->validate([
            'name' => 'string|max:250',
            'email' => 'email|max:250',
            'bio' => 'nullable|string'
        ]);
        $user->name = empty($request->input('name')) ? $user->name : $request->input('name');
        $user->email = empty($request->input('email')) ? $user->email : $request->input('email');
        $user->bio = empty($request->input('bio')) ? '' : $request->input('bio');
        $user->save();
        return redirect()->route('profile', [$user])
            ->with('success', 'Successfully changed!');
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
            redirect()->route('profile', [$user->id])->withErrors(['error' => 'Error deleting account!']);
    }

    public function destroy(Request $request)
    {
        User::where('id', $request->input("request"))
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
        return redirect($user->getProfileImage());
    }

    public function revoke_moderator(Request $request)
    {

        $request->validate([
            'id' => 'integer|required'
        ]);

        $user = User::findOrFail($request->input('id'));
        $user->type = 'authenticated';
        $user->id_topic = NULL;
        $user->save();

        return response()->json(['success' => "Revoked moderator"]);
    }

    public function make_moderator(Request $request)
    {

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
    }

    public function upgrade(Request $request)
    {
        $user = User::find($request->input("idUser"));
        $user->update(['id_topic' => null]);
        $user->type = 'admin';
        $user->save();
        return response()->json(['success' => 'admin', 'id' => $user->id]);
    }
}
