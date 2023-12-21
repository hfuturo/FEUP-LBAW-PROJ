<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return Auth::check() && (Auth::user()->id === $user->id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return Auth::check() && (Auth::user()->id === $user->id || Auth::user()->is_admin());
    }

    public function show(User $user)
    {
        return Auth::check();
    }

    public function block(User $currentUser, User $user): bool
    {
        return $currentUser->is_admin() && $currentUser->id !== $user->id;
    }

    public function unblock(): bool
    {
        return Auth::user()->is_admin();
    }

    public function change_moderator(User $currentUser): bool
    {
        return $currentUser->is_admin();
    }

    public function upgrade(User $currentUser, User $user): bool
    {
        return $currentUser->is_admin() && $user->type !== 'admin';
    }
}
