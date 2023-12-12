<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notified extends Model
{
    use HasFactory;
    public $timestamps  = false;
    public $incrementing = false;
    protected $table = 'notified';

    protected $fillable = [
        'id_notification',
        'id_notified',
        'date',
        'view'
    ];

    protected $primaryKey = ['id_notification', 'id_notified'];

    public function notification() {
        return $this->belongsTo(Notification::class,'id_notification','id');
    }

    public function user() {
        return $this->belongsTo(User::class,'id_notified','id');
    }
}
