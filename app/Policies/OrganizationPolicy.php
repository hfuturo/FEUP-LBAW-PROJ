<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Organization;
use App\Models\MembershipStatus;
use Illuminate\Support\Facades\Auth;

class OrganizationPolicy
{

    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function show_manage(User $user, Organization $organization): bool
    {
        $status = MembershipStatus::where('id_user','=',$user->id)->where('id_organization','=',$organization->id)->first();
        return $status->member_type === 'leader';
    }

    public function update(User $user, Organization $organization): bool
    {
        $status = MembershipStatus::where('id_user','=',$user->id)->where('id_organization','=',$organization->id)->first();
        return $status->member_type === 'leader';
    }

    public function destroy(User $user, Organization $organization): bool
    {
        $status = MembershipStatus::where('id_user', $user->id)
        ->where('id_organization', $organization->id)
        ->first();
        return $status->member_type === 'leader';
    }

}
?>