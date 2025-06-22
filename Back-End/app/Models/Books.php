<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    // Use snake_case and match migration exactly
    protected $fillable = [
        'image',
        'isbn',
        'title',
        'author',
        'publication_year',
        'number_of_copies',
        'category',
        'priority',
    ];

    protected $appends = ['image_url'];

    // Accessor for full image URL
    public function getImageUrlAttribute()
    {
        return $this->image
            ? url('storage/' . $this->image)
            : null;
    }
}
