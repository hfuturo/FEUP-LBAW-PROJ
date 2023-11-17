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

    public function topic() {
        return $this->hasOne(Topic::class,'id_topic');
    }

    public function suggested_topics() {
        return $this->hasMany(Suggested_Topic::class,'id_user');
    }

    public function contents() {
        return $this->hasMany(Content::class,'id_author');
    }

    public function reports_made() {
        return $this->hasMany(Report::class,'id_reporter');
    }

    public function reported() {
        return $this->hasMany(Report::class,'id_user');
    }

    public function notifications() {
        return $this->hasMany(Notification::class,'id_user');
    }

    public function follow_organizations() {
        return $this->hasMany(Follow_Organization::class,'id_following');
    }

    public function follow_tags() {
        return $this->hasMany(Follow_Tag::class,'id_following');
    }

    public function follow_topics() {
        return $this->hasMany(Follow_Topic::class,'id_following');
    }

    public function following() {
        return $this->hasMany(Follow_User::class,'id_follower');
    }

    public function followers() {
        return $this->hasMany(Follow_User::class,'id_following');
    }

    public function votes(){
      return $this
        ->belongsToMany(Project::class, 'vote', 'id_user', 'id_content')
        ->withPivot('vote');
    }
    
    public function news_items() {
        return $this->contents()
        ->with('news_items');
    }

    public function is_admin()
    {
        return $this->type === 'admin';
    }
}
