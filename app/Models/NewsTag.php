<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsTag extends Model
{
    use HasFactory;
    public $timestamps  = false;
    public $incrementing = false;
    protected $table = 'news_tag';
    
    protected $fillable = [
        'id_news_item',
        'id_tag'
    ];

    protected $primaryKey = ['id_news_item','id_tag'];

    public function tag() {
        return $this->belongsTo(Tag::class,'id_tag');
    }

    public function news_item() {
        return $this->belongsTo(NewItem::class,'id');
    }
}