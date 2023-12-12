<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FollowTopic;

class FollowTopicPolicy
{
    public function destroy(User $user, FollowTopic $followTopic)
    {
        return $user->id == $followTopic->id_following;
    }
}

