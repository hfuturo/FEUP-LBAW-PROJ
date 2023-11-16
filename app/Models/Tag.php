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

    public function followers() {
        return $this->hasMany(Follow_Tag::class,'id_tag');
    }

    public function reports() {
        return $this->hasMany(Report::class,'id_tag');
    }

    public function news_item() {
        return $this->hasMany(Tag::class, 'news_tag', 'id_tag', 'id_news_item');
    }
}
