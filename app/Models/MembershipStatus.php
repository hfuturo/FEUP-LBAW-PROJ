<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipStatus extends Model
{
    use HasFactory;
    public $timestamps  = false;
    public $incrementing = false;
    protected $table = 'membership_status';

    protected $fillable = [
        'id_user',
        'id_organization',
        'joined_date',
        'member_type'
    ];

    protected $primaryKey = ['id_user','id_organization'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'id_organization');
    }

}
