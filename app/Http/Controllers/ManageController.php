<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\SuggestedTopic;


class ManageController extends Controller
{
    public function show()
    {
        $this->authorize('show', \App\Manage::class);

        $users = User::all();
        return view('pages.manage', [
            'users' => $users
        ]);
    }

    public function search(Request $request)
    {
        $users = DB::table('authenticated_user')
            ->where('name', 'ilike', "%{$request->input('search')}%")
            ->get();

        return response()->json($users);
    }

    public function show_suggested_topic()
    {
        $this->authorize('show_suggested_topic', \App\Manage::class);
        $suggested_topic = SuggestedTopic::join('authenticated_user', 'suggested_topic.id_user', '=', 'authenticated_user.id')
            ->select('suggested_topic.*', 'authenticated_user.name as user_name');
        return view('pages.manage_topic', [
            'suggested_topic' => $suggested_topic
        ]);
    }
}
