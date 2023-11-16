<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow_Tag extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'follow_tag';

    protected $fillable = [
        'id_tag',
        'id_following'
    ];

    protected $primaryKey = ['id_tag','id_following'];

    public function authenticated_user() {
        return $this->belongsTo(User::class,'id_following');
    }

    public function tag() {
        return $this->belongsTo(Tag::class,'id_tag');
    }
}
