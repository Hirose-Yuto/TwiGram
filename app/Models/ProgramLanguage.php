<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramLanguage extends Model
{
    use HasFactory;
    protected $primaryKey = "program_language_id";
    public $timestamps = false;
    public $incrementing = false;
}
