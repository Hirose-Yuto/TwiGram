<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Twig extends Model
{
    use HasFactory, Searchable;
    protected $primaryKey = "twig_id";

    protected $guarded = [
        "twig_id",
    ];
}
