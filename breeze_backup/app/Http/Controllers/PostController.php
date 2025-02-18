<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Storage;

class PostController extends Controller
{
    function index() {
        $posts = Post::where("status", "=", "p")->get();
        return view("blog.list", compact("posts"));
    }

    function show(string $slug){
        $post = Post::where("slug", "=", $slug, "and")->where("status", "=", "p")->firstOrFail();
        return view("blog.detail", compact("post"));
    }

    function preview(string $slug){
        $user = auth()->user();
        $post = Post::where("slug", "=", $slug, "and")->where("status", "=", "d", "and")->where("author","=",auth()->user()->id, "or")->firstOrFail();
        if($user->is_superuser){
            $post = Post::where("slug", "=", $slug,"and")->where("status", "=", "d")->firstOrFail();
        }
        return view("blog.detail", compact("post"));
    }

    function create() {
        $tags = Tag::all();;
        return view("dashboard.create", compact("tags"));
    }

    function store(PostRequest $request){
        $user = $request->user();
        $post = new Post();
        if($request->hasFile("image")){
            $post_image = $request->file("image");
            $username = auth()->user()->username;
            $folderPath = 'post_images/' . $username;

            if(!Storage::disk("post_public")->exists($username)){
                Storage::disk("post_public")->makeDirectory($username);
            }
            $postName = time() . "." . $post_image->getClientOriginalExtension();
            $filePath = $username . "/" . $postName;
            $post_image->storeAs("/", $filePath, "post_public");
            $post->post_image = 'post_images/' . $username . "/" . $postName;
        }

        $selectedTags = $request->input('tags', []);
        $post->tags()->sync($selectedTags);
        $post->title = $request->title;
        if(auth()->user()->is_superuser){
            $post->status = $request->status;
        }
        $post->slug = $request->slug;
        $post->save();
        return redirect()->route("dashboard.panel");
    }
}
