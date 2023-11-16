<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'notification';

    protected $fillable = [
        'notification_type',
        'member_type',
        'id_organization',
        'id_content',
        'id_user'
    ];
    
    /* types */
    public function organization() {
        return $this->belongsTo(Organization::class,'id_organization');
    }

    public function content() {
        return $this->belongsTo(Content::class,'id_content');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_user');
    }
}
