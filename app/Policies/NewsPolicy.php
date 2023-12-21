<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NewsItem;

use Illuminate\Support\Facades\Auth;

class NewsPolicy
{
    public function __construct()
    {
        //
    }

    public function create(User $user): bool
    {
        // Any user can create a new card.
        return Auth::check();
    }

    public function follow_list(): bool
    {
        return Auth::check();
    }

    public function recent_list(): bool
    {
        return true;
    }
}
