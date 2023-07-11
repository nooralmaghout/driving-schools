<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $table = "questions";

    protected $fillable = ["question","choice1","choice2","choice3","answer","mark"];

    public $timestamps = false;
}
