<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsItem extends Model
{
    use HasFactory;

    public $timestamps  = false;

    public $incrementing = false;

    protected $table = 'news_item';

    protected $fillable = [
        'id_topic',
        'title',
        'image'
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'id_topic');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_news');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'news_tag', 'id_news_item', 'id_tag');
    }

    public function votes()
    {
        return $this
            ->hasMany(Vote::class, 'id_content');
    }

    public static function exact_match_search(string $query)
    {
        $query = str_replace('%', '\%', $query);
        return DB::table('news_item')
            ->selectRaw('content.*,news_item.*')
            ->join('content', 'content.id', '=', 'news_item.id')

            ->where('news_item.title', 'LIKE', '% ' . trim($query) . ' %', 'or')
            ->where('news_item.title', 'LIKE', trim($query) . ' %', 'or')
            ->where('news_item.title', 'LIKE', '% ' . trim($query) . ' %', 'or')
            ->where('news_item.title', 'LIKE', trim($query), 'or')

            ->where('content.content', 'LIKE', '% ' . trim($query) . ' %', 'or')
            ->where('content.content', 'LIKE',  trim($query) . ' %', 'or')
            ->where('content.content', 'LIKE', '% ' . trim($query), 'or')
            ->where('content.content', 'LIKE', trim($query), 'or')

            ->orderBy('date', 'DESC');
    }

    public static function full_text_search(string $query)
    {
        $sub = (DB::table('news_item')
            ->select('*')
            ->from(DB::raw('news_item, websearch_to_tsquery(\'english\',?) query'))
            ->whereRaw('tsvectors @@ query')
            ->orderByRaw('ts_rank(tsvectors, query) desc')
            ->setBindings([$query]));
        return Content::joinSub(
            $sub,
            'news',
            function ($join) {
                $join->on(DB::Raw('content.id'), '=', DB::Raw('news.id'));
            }
        );
    }
}
