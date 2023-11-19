<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Suggested_Topic;


class ManageController extends Controller
{
    public function show()
    {
        $this->authorize('show',\App\Manage::class);

        $users = User::all();
        return view('pages.manage', [
            'users' => $users
        ]);
    }

    public function search(Request $request) {
        $users = DB::table('authenticated_user')
            ->where('name', 'LIKE', "{$request->input('search')}%")
            ->get();
            
        return response()->json($users);
    }

    public function show_suggested_topic(){
        $this->authorize('show_suggested_topic',\App\Manage::class);
        $suggested_topic = Suggested_Topic::join('authenticated_user', 'suggested_topic.id_user', '=', 'authenticated_user.id')
            ->select('suggested_topic.*', 'authenticated_user.name as user_name');
        return view('pages.manage_topic', [
            'suggested_topic' => $suggested_topic
        ]);
    }
}