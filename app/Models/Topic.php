<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'topic';

    protected $fillable = [
        'name'
    ];

    public function news_item()
    {
        return $this->hasMany(NewsItem::class, 'id_topic');
    }

    public function followers()
    {
        return $this->hasMany(FollowTopic::class, 'id_topic');
    }

    public function moderators()
    {
        return $this->hasMany(User::class, 'id_topic');
    }
}
