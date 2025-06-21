<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorModel extends Model
{
    protected $table = 'authors';
    protected $fillable = [
        'name',
        'dateofbirth',
        'nationality',
        'numberOfWrittenBook',
        'image'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
{
    return $this->image
        ? url($this->image)
        : null;
}

}
