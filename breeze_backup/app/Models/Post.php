<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    use HasRelationships;

    function user(){
        return $this->belongsTo(User::class, "author");
    }

    function tags(){
        return $this->belongsToMany(Tag::class);
    }
}
