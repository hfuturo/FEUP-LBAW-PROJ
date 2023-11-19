<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'news_item';

    protected $fillable = [
        'id_topic',
        'title',
        'image'
    ];

    public function topic() {
        return $this->belongsTo(Topic::class,'id_topic');
    }

    public function comments() {
        return $this->hasMany(Comment::class,'id_news');
    }

    public function content() {
        return $this->belongsTo(Content::class,'id_topic');
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'news_tag', 'id_news_item', 'id_tag');
    }

    public function votes(){
        return $this
          ->belongsToMany(Project::class, 'vote', 'id_content', 'id_user')
          ->withPivot('vote');
    }
}
