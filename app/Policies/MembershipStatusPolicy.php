<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MembershipStatus;

class MembershipStatusPolicy
{
    public function upgrade(User $user, MembershipStatus $status)
    {
        return $status->member_type === 'leader';
    }
    public function expel(User $user, MembershipStatus $status)
    {
        return $status->member_type === 'leader';
    }
    public function decline(User $user, MembershipStatus $status)
    {
        return $status->member_type === 'leader';
    }
    public function accept(User $user, MembershipStatus $status)
    {
        return $status->member_type === 'leader';
    }
}

