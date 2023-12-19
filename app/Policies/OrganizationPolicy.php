<?php

namespace App\Policies;

use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\MembershipStatus;
use App\Models\User;

class OrganizationPolicy
{
    public function destroy(User $user, Organization $organization): bool
    {
        $status = MembershipStatus::where('id_user', $user->id)
        ->where('id_organization', $organization->id)
        ->first();
        return $status->member_type === 'leader';
    }

}
