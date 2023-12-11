<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function show_users(User $user): bool
    {
        return $user->is_admin();
    }

    public function show_news(User $user): bool
    {
        return $user->is_admin();
    }

    public function show_comments(User $user): bool
    {
        return $user->is_admin();
    }

    public function destroy(User $user): bool
    {
        return $user->is_admin();
    }
}
