<?php

namespace App\Policies;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

class ManagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if user can see manage's page content
     */
    public function show(): bool
    {
        return Auth::check() && Auth::user()->is_admin();
    }

    public function show_suggested_topic()
    {
        return Auth::check() && Auth::user()->is_admin();
    }

    public function show_unblock_appeals()
    {
        return Auth::check() && Auth::user()->is_admin();
    }
}
