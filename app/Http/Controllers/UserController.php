<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $this->authorize('show',\App\User::class);

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
        $this->authorize('update',\App\User::class);

        if($user->email !== $request->input('email')) {
            $validator_unique=$request->validate(['email' => 'unique:authenticated_user']);
            if (!$validator_unique) {
                return back()->withErrors(['error', 'The email inserted is already being used!']);;
            }
        }
        $validator=$request->validate([
            'name' => 'string|max:250',
            'email' => 'email|max:250',
            'bio' => 'nullable|string'
        ]);
        if ($validator) {
            $user->name = empty($request->input('name')) ? $user->name : $request->input('name');
            $user->email = empty($request->input('email')) ? $user->email : $request->input('email');
            $user->bio = empty($request->input('bio')) ? '' : $request->input('bio');
            $user->save();       
            return redirect()->route('profile',[$user])
            ->with('success', 'Successfully changed!');
        }
        else{
            return redirect()->route('profile',[$user])->withErrors(['error', 'The parameters are invalid!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
