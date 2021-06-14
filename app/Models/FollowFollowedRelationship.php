<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowFollowedRelationship extends Model
{
    use HasFactory;
    protected $primaryKey = ["following_user_id", "followed_user_id"];
    public $incrementing = false;
    protected $fillable = ["following_user_id", "followed_user_id"];
}
