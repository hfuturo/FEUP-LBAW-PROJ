<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'tag';

    protected $fillable = [
        'name'
    ];

    public function followers()
    {
        return $this->hasMany(FollowTag::class, 'id_tag');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'id_tag');
    }

    public function news_item()
    {
        return $this->belongsToMany(Tag::class, 'news_tag', 'id_tag', 'id_news_item');
    }

    public static function parse_tags(?string $tagsStr)
    {
        $tags = [];

        if ($tagsStr) {
            if (str_starts_with($tagsStr, "#")) {
                $tagsStr = substr($tagsStr, 1);
            }
            $tags = array_map(function ($tag) {
                return "#" . trim($tag);
            }, explode("#", $tagsStr));
        }

        return $tags;
    }
}
