<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class School extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "schools";

    protected $fillable = ["name","email","password","about","location","city"];

    public $timestamps = false;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }
}
