<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

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

    public function dislikes()
    {
        return $this
            ->votes()->where('vote', -1)->count();
    }

    public function likes()
    {
        return $this
            ->votes()->where('vote', 1)->count();
    }

    public static function exact_match_search(string $query)
    {
        $select = DB::table('news_item')
            ->selectRaw('content.*,news_item.*')
            ->join('content', 'content.id', '=', 'news_item.id')
            ->orderBy('date', 'DESC');
        $select = NewsItem::add_exact_match_text_filter($select, $query, 'news_item.title');
        $select = NewsItem::add_exact_match_text_filter($select, $query, 'content.content');

        return $select;
    }

    public static function add_exact_match_text_filter(Builder $select, ?string $query, string $field)
    {
        if (is_null($query) or $query === '') return $select;
        $query = str_replace('%', '\%', $query);
        return $select->where($field, 'LIKE', '% ' . trim($query) . ' %', 'or')
            ->where($field, 'LIKE',  trim($query) . ' %', 'or')
            ->where($field, 'LIKE', '% ' . trim($query), 'or')
            ->where($field, 'LIKE', trim($query), 'or');
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
