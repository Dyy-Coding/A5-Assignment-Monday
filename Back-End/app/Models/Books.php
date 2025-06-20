<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $fillable = [
        "id",
        "image",
        "title",
        "Isnb",
        "author",
        "Publication_years",
        "Number_of_Copies",
        "Categories"
    ];
}
