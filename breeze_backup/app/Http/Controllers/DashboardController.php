<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function panel(){
        if(auth()->user()->is_superuser){
            $users = User::all();
            $posts = Post::all();
            $tags = Tag::all();
            return view("dashboard.panel", compact("users", "posts", "tags"));
        }
        $posts = auth()->user()->posts;
        return view("dashboard.panel", compact("posts"));
    }
}
