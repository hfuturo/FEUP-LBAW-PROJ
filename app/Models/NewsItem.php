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

    public static function multi_filter(
        ?string $exact_match,
        ?string $title,
        ?string $content,
        ?string $author,
        ?int $topic,
        array $tags,
    ) {
        $select = DB::table('news_item')
            ->selectRaw('content.*,news_item.*')
            ->join('content', 'content.id', '=', 'news_item.id')
            ->join('authenticated_user', 'authenticated_user.id', '=', 'content.id_author', 'left')
            ->join('topic', 'topic.id', '=', 'news_item.id_topic')
            ->joinSub(function ($select) {
                $select->select(DB::raw("string_agg(tag.name,' ') as tag_name, news_item.id as news_id"))
                    ->from("news_tag")
                    ->join("news_item", DB::raw("news_item.id"), "=", DB::raw("news_tag.id_news_item"))
                    ->join("tag", DB::raw("news_tag.id_tag"), "=", DB::raw("tag.id"))
                    ->groupBy("news_item.id");
            }, "tags", "tags.news_id", "=", "news_item.id")
            ->orderBy('date', 'DESC');

        $select->where(function ($select) use ($exact_match) {
            NewsItem::add_exact_match_text_filter($select, $exact_match, 'news_item.title');
            NewsItem::add_exact_match_text_filter($select, $exact_match, 'content.content');
            NewsItem::add_exact_match_text_filter($select, $exact_match, 'coalesce("authenticated_user" . "name", \'Anonymous\')');
            NewsItem::add_exact_match_text_filter($select, $exact_match, 'topic.name');
            NewsItem::add_exact_match_text_filter($select, $exact_match, 'tag_name');
        });

        $select->where(function ($select) use ($title) {
            NewsItem::add_exact_match_text_filter($select, $title, 'news_item.title');
        });

        $select->where(function ($select) use ($content) {
            NewsItem::add_exact_match_text_filter($select, $content, 'content.content');
        });

        $select->where(function ($select) use ($author) {
            NewsItem::add_exact_match_text_filter($select, $author, 'coalesce("authenticated_user" . "name", \'Anonymous\')');
        });

        $select->where(function ($select) use ($topic) {
            NewsItem::add_exact_match_int_filter($select, $topic, 'news_item.id_topic');
        });

        $select->where(function ($select) use ($tags) {
            NewsItem::add_exact_match_array_filter($select, $tags, 'tags');
        });

        return $select;
    }

    public static function add_exact_match_text_filter(Builder $select, ?string $query, string $field)
    {
        if (is_null($query) or $query === '') return $select;
        $query = str_replace('%', '\%', $query);
        return $select->where(DB::Raw($field), 'LIKE', '% ' . trim($query) . ' %', 'or')
            ->where(DB::Raw($field), 'LIKE',  trim($query) . ' %', 'or')
            ->where(DB::Raw($field), 'LIKE', '% ' . trim($query), 'or')
            ->where(DB::Raw($field), 'LIKE', trim($query), 'or');
    }

    public static function add_exact_match_int_filter(Builder $select, ?int $query, string $field)
    {
        if (is_null($query)) return $select;
        return $select->where($field, '=', $query);
    }

    public static function add_exact_match_array_filter(Builder $select, array $items, string $field)
    {
        if (count($items) === 0) return $select;

        return $select->where(function (Builder $query) use ($items) {
            $query
                ->select(DB::raw("count(*)"))
                ->from("news_tag")
                ->join("tag", DB::raw("news_tag.id_tag"), "=", DB::raw("tag.id"))
                ->where(DB::raw("news_tag.id_news_item"), "=", DB::raw("news_item.id"))
                ->where(function (Builder $where) use ($items) {
                    foreach ($items as $item) {
                        $where->where(DB::raw("tag.name"), "=", $item, "or");
                    }
                });
        }, "=", count($items));
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
