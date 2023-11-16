<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'comment';

    protected $fillable = [
        'id_news'
    ];

    public function news_item() {
        return $this->belongsTo(News_Item::class,'id_news');
    }

    public function content() {
        return $this->belongsTo(Content::class);
    }
}
