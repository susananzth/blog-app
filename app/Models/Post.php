<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body'];

    /**
     * Get all of the categories for the post.
     */
    public function categories()
    {
        return $this->morphToMany(Category::class, 'categorable');
    }
}
