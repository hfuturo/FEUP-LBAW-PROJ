<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowTopic extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'follow_topic';

    protected $fillable = [
        'id_topic',
        'id_following'
    ];

    protected $primaryKey = ['id_topic','id_following'];

    public function authenticated_user() {
        return $this->belongsTo(User::class,'id_following');
    }

    public function topic() {
        return $this->belongsTo(Topic::class,'id_topic');
    }
}
