<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz_list extends Model
{
    use HasFactory;
    public $fillable=[
        "title","quiz","answer","ptn","theme_name","level"
    ];
}
