<?php

// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    use HasFactory;

    protected $fillable = [
        'FirstName',
        'LastName',
        'Email',
        'Phone',
        'Address',
        'Image',
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
