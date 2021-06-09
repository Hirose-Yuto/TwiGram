<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Twig extends Model
{
    use HasFactory;
    protected $primaryKey = "twig_id";

    protected $guarded = [
        "twig_id",
        "twig_from",
    ];
}
