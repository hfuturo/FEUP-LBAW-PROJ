<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vote extends Model
{
  use HasFactory;

  public $timestamps  = false;

  public $incrementing = true;

  protected $table = 'vote';

  protected $fillable = [
    'vote'
  ];
}
