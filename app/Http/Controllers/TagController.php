<?php

namespace App\Http\Controllers;

use App\Http\Middleware\TagSuperuserCheckMiddleware;
use App\Http\Requests\TagRequest;
use App\Models\Tag;
use \Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Str;

class TagController extends Controller implements HasMiddleware
{
    public static function middleware(){
        return [new Middleware(TagSuperuserCheckMiddleware::class, except: ['detail'])];
    }

    function detail($slug){
        $tags = Tag::all();
        $tag = Tag::whereSlug($slug)->firstOrFail();
        $posts = $tag->publishedPosts;
        return view("blog.list", compact("posts", "tag", "tags"));
    }

    function create(){
        return view("tags.create");
    }

    function store(TagRequest $request){
        $tag = new Tag();
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->slug);
        $tag->save();
        return redirect()->route("dashboard.panel");
    }
    function edit(string $id){
        $tag = Tag::findOrFail($id);
        return view("tags.update", compact("tag"));
    }

    function update(TagRequest $request, Tag $tag){
        $tag->name = $request->name;
        $tag->slug = Str::slug($request->slug);
        $tag->save();
        return redirect()->route("dashboard.panel");
    }

    function destroy(string $id){
        $tag = Tag::findOrFail($id);
        $tag->delete();
        // return "deleted";
        return redirect()->route("dashboard.panel");
    }
}
