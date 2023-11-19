<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggested_Topic extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'suggested_topic';

    protected $fillable = [
        'name',
        'justification',
        'id_user'
    ];
    
    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }
}
