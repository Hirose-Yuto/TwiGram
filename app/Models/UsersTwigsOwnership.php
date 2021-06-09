<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTwigsOwnership extends Model
{
    use HasFactory;
    protected $primaryKey = "ownership_id";

    protected $fillable = [
        "retwig_comment"
    ];
}
