<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FollowUser;

class FollowUserPolicy
{
    public function destroy(User $user, FollowUser $followUser)
    {
        return $user->id == $followUser->id_follower;
    }
}

