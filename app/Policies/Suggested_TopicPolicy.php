<?php

namespace App\Policies;

use App\Models\Suggested_Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class Suggested_TopicPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Suggested_Topic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return Auth::check();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Suggested_Topic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Suggested_Topic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Suggested_Topic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Suggested_Topic $suggestedTopic): bool
    {
        //
    }

    public function destroy($topic)
    {
        return Auth::check() && Auth::user()->is_admin();
    }

    public function accept($name)
    {
        return Auth::check() && Auth::user()->is_admin();
    }
}
