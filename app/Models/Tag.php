<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    use HasRelationships;

    protected $fillable = [
        "name",
        "slug",
    ];
    function posts(){
        return $this->belongsToMany(Post::class);
    }
    function publishedPosts(){
        return $this->belongsToMany(Post::class)->where("status", "=", "p");
    }
}
