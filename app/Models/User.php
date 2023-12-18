<?php

namespace App\Models;

use Illuminate\Pagination\LengthAwarePaginator;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

// Added to define Eloquent relationships.
use Illuminate\Database\Eloquent\Relations\HasMany;

use App\Http\Controllers\FileController;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public $timestamps  = false;
    protected $table = 'authenticated_user';

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'reputation',
        'bio',
        'blocked',
        'user_type',
        'id_topic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function topic()
    {
        return $this->hasOne(Topic::class, 'id_topic');
    }

    public function suggested_topics()
    {
        return $this->hasMany(SuggestedTopic::class, 'id_user');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'id_author');
    }

    public function reports_made()
    {
        return $this->hasMany(Report::class, 'id_reporter');
    }

    public function reported()
    {
        return $this->hasMany(Report::class, 'id_user');
    }

    public function notified()
    {
        return $this->hasMany(Notified::class, 'id_notified');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_user');
    }

    public function follow_organizations()
    {
        return $this->hasMany(FollowOrganization::class, 'id_following');
    }

    public function follow_tags()
    {
        return $this->hasMany(FollowTag::class, 'id_following');
    }

    public function follow_topics()
    {
        return $this->hasMany(FollowTopic::class, 'id_following');
    }

    public function following()
    {
        return $this->hasMany(FollowUser::class, 'id_follower');
    }

    public function followers()
    {
        return $this->hasMany(FollowUser::class, 'id_following');
    }

    public function membershipStatuses()
    {
        return $this->hasMany(MembershipStatus::class, 'id_user');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'membership_status', 'id_user', 'id_organization')
            ->whereIn('member_type', ['member', 'leader']);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class, 'id_user');
    }

    public function news_items()
    {
        return $this->contents()
            ->whereHas('news_items')
            ->whereDoesntHave('comments');
    }


    public function notified_ordered()
    {
        return $this->notified()->orderBy('date', 'desc');
    }

    public function is_admin()
    {
        return $this->type === 'admin';
    }

    public function getProfileImage()
    {
        return FileController::get('profile', $this->id);
    }
}
