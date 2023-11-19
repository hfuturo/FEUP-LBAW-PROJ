<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembershipStatus extends Model
{
    use HasFactory;
    public $timestamps  = false;
    protected $table = 'membership_status';

    protected $fillable = [
        'id_user',
        'id_organization',
        'joined_date',
        'member_type'
    ];

    protected $primaryKey = ['id_user','id_organization'];

}
