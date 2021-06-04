<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersTwigsOwnership extends Model
{
    use HasFactory;
    protected $primaryKey = ["user_id", "twig_id"];
    public $incrementing = false;
}
