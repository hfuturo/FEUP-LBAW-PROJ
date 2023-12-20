<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\SuggestedTopic;
use App\Models\Topic;

class ManageController extends Controller
{
    public function show()
    {
        $this->authorize('show', \App\Manage::class);

        $users = User::all();
        $topics = Topic::all();
        return view('pages.manage', [
            'users' => $users,
            'topics' => $topics
        ]);
    }

    public function search(Request $request)
    {
        $users = DB::table('authenticated_user')
            ->where('name', 'ilike', "%{$request->input('search')}%")
            ->get();

        $topics = Topic::all();
        $topicsMap = $topics->pluck('name', 'id')->toArray();
        return response()->json(['users' => $users, 'topics' => $topicsMap]);
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

    public function show_unblock_appeals()
    {
        $this->authorize('show_unblock_appeals', \App\Manage::class);

        $users = User::where('blocked_appeal', '<>', '')->where('appeal_rejected', '=', 'false')->paginate(10);
        return view('pages.manage_unblock_appeals', ['users' => $users]);
    }
}
