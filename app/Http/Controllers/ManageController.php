<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\User;


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
}