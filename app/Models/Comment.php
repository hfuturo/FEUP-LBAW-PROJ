<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'comment';

    protected $fillable = [
        'id_news'
    ];

    public function news_item()
    {
        return $this->belongsTo(NewsItem::class, 'id_news');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'id');
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

    public static function full_text_search(string $query)
    {
        return (Comment::select('*')
            ->from(DB::raw('comment, websearch_to_tsquery(\'english\',?) query'))
            ->whereRaw('tsvectors @@ query')
            ->orderByRaw('ts_rank(tsvectors, query) desc')
            ->setBindings([$query]));
    }
}
