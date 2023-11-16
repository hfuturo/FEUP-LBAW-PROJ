<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow_Organization extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'follow_organization';

    protected $fillable = [
        'id_organization',
        'id_following'
    ];

    protected $primaryKey = ['id_organization','id_following'];

    public function authenticated_user() {
        return $this->belongsTo(User::class,'id_following');
    }

    public function organization() {
        return $this->belongsTo(Organization::class,'id_organization');
    }
}
