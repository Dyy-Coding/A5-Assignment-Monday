<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{
    protected $table = 'authors'; // Change this if your table is named differently

    protected $fillable = [
        'name',
        'dateofbirth',
        'nationality',
        'numberOfWrittenBook',
    ];
    public $timestamps = false;
}
