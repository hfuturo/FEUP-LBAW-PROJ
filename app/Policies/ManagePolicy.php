<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class ManagePolicy
{
    /**
     * Determine if user can see manage's page content
     */
    public function show(): bool
    {
        return Auth::check() && Auth::user()->is_admin();
    }

    public function show_unblock_appeals()
    {
        return Auth::check() && Auth::user()->is_admin();
    }
}
