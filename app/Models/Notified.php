<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notified extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'notified';

    protected $fillable = [
        'id_notification',
        'id_notified',
        'date',
        'view'
    ];

    protected $primaryKey = ['id_notification','id_notified'];
}
