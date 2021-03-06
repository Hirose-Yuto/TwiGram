<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersLikes extends Model
{
    use HasFactory;
    protected $primaryKey = "like_id";

    protected $fillable = [
        "user_id",
        "twig_id"
    ];

}
