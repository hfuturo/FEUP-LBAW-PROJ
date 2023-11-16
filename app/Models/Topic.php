<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'topic';

    protected $fillable = [
        'name'
    ];
    
    public function news_item() {
        return $this->hasMany(News_Item::class,'id_topic');
    }

    public function followers() {
        return $this->hasMany(Follow_Topic::class,'id_topic');
    }

    public function moderators() {
        return $this->belongsToMany(Authenticated_User::class,'id_topic');
    }
}
