<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;

class BlockPolicy
{
    public function blockPage(): bool
    {
        return Auth::check() && Auth::user()->blocked;
    }

    public function appeal_unblock(): bool
    {
        return Auth::check() && Auth::user()->blocked;
    }
}
