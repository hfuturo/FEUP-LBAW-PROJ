<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'organization';

    protected $fillable = [
        'name',
        'bio'
    ];

    public function contents()
    {
        return $this->hasMany(Content::class, 'id_organization');
    }

    public function followers()
    {
        return $this->hasMany(FollowOrganization::class, 'id_organization');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_organization');
    }

    public function membershipStatuses()
    {
        return $this->hasMany(MembershipStatus::class, 'id_user');
    }

    public function members()
    {
        return $this->hasMany(MembershipStatus::class,  'id_organization')->where(function ($query) {
            $query->where('member_type', '=', 'member')
                ->orWhere('member_type', '=', 'leader');
        });
    }
}
