<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}