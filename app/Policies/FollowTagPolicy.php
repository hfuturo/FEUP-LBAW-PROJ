<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FollowTag;

class FollowTagPolicy
{
    public function destroy(User $user, FollowTag $followTag)
    {
        return $user->id == $followTag->id_following;
    }
}

