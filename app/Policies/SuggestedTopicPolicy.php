<?php

namespace App\Policies;

use App\Models\SuggestedTopic;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class SuggestedTopicPolicy
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
    public function view(User $user, SuggestedTopic $suggestedTopic): bool
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
    public function update(User $user, SuggestedTopic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuggestedTopic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SuggestedTopic $suggestedTopic): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SuggestedTopic $suggestedTopic): bool
    {
        //
    }

    public function destroy()
    {
        return Auth::check() && Auth::user()->is_admin();
    }

    public function accept()
    {
        return Auth::check() && Auth::user()->is_admin();
    }
}
