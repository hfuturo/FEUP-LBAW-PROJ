<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow_User extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'follow_user';

    protected $fillable = [
        'id_follower',
        'id_following'
    ];

    protected $primaryKey = ['id_follower','id_following'];

    public function follower() {
        return $this->belongsTo(User::class,'id_follower');
    }

    public function following() {
        return $this->belongsTo(User::class,'id_following');
    }
}
