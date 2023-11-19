<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class News_Item extends Model
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
        return $this->belongsTo(Content::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class, 'news_tag', 'id_news_item', 'id_tag');
    }

    public function votes(){
        return $this
          ->belongsToMany(Project::class, 'vote', 'id_content', 'id_user')
          ->withPivot('vote');
    }

    public static function full_text_search($query){
        $sub = (DB::table('news_item')
                ->select('id')
                ->from(DB::raw('news_item, plainto_tsquery(\'english\',?) query'))
                ->whereRaw('tsvectors @@ query')
                ->orderByRaw('ts_rank(tsvectors, query) desc')
                ->setBindings([$query]));
        return Content::joinSub($sub, 'news', function($join)
            {
                $join->on(DB::Raw('content.id'), '=', DB::Raw('news.id'));
            }
        );
    }
}
