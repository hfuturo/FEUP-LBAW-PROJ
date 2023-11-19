<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Content extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'content';

    protected $fillable = [
        'content',
        'date',
        'edit_date',
        'id_author',
        'id_organization'
    ];

    public function authenticated_user() {
        return $this->belongsTo(User::class,'id_author');
    }

    public function organization() {
        return $this->belongsTo(Organization::class,'id_organization');
    }

    public function reports() {
        return $this->hasMany(Reporter::class,'id_content');
    }

    public function notifications() {
        return $this->hasMany(Notification::class,'id_content');
    }

    public function news_items()
    {
        return $this->hasOne(NewsItem::class, 'id');
    }

    public function comments()
    {
        return $this->hasOne(Comment::class, 'id');
    }
}
