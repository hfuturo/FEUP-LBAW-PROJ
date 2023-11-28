<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'report';

    protected $fillable = [
        'reason',
        'date',
        'type',
        'id_reporter',
        'id_tag',
        'id_content',
        'id_user'
    ];
    
    public function author() {
        return $this->belongsTo(Authenticated::class,'id_reporter');
    }

    /* types */
    public function content() {
        return $this->belongsTo(Content::class,'id_content');
    }

    public function tag() {
        return $this->belongsTo(Tag::class,'id_tag');
    }

    public function user() {
        return $this->belongsTo(Authenticated::class,'id_user');
    }
}
