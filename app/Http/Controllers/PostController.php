<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Storage;
use Str;

class PostController extends Controller
{
    function index() {
        $tags = Tag::all();
        $posts = Post::where("status", "=", "p")->orderByDesc("id")->get();
        return view("blog.list", compact("posts", "tags"));
    }

    function show(string $slug){
        $tags = Tag::all();
        $post = Post::where("slug", "=", $slug, "and")->where("status", "=", "p")->firstOrFail();
        return view("blog.detail", compact("post", "tags"));
    }

    function preview(string $slug){
        $user = auth()->user();
        $post = Post::where("slug", "=", $slug, "and")->where("status", "=", "d", "and")->where("author","=",auth()->user()->id, "or")->firstOrFail();
        $tags = Tag::all();
        if($user->is_superuser){
            $post = Post::where("slug", "=", $slug,"and")->where("status", "=", "d")->firstOrFail();
        }
        return view("blog.detail", compact("post", "tags"));
    }

    function create() {
        $tags = Tag::all();
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

        $post->title = $request->title;
        $post->content = $request->content;
        $post->status = 'd';
        if(auth()->user()->is_superuser){
            $post->status = $request->status;
        }
        $post->slug = Str::slug($request->slug);
        $post->author = auth()->user()->id;
        $post->save();
        $tags = array_map('intval', $request->tags);
        $post->tags()->sync($tags);
        return redirect()->route("dashboard.panel");
    }

    function edit(string $id){
        $tags = Tag::all();
        if(auth()->user()->is_superuser){
            $post = Post::findOrFail($id);
        } else{
            $post = Post::where("id", "=", $id, "and")->where("author", "=", auth()->user()->id)->firstOrFail();
        }
        if ($post){
            return view("dashboard.update", compact("post", "tags"));
        } 
        return abort(404);
    }

    function update(Request $request, Post $post){
        $request->validate([
            "title" => ["required", "max:40"],
            "content" => ["required"],
            "slug" => ["required", Rule::unique('posts')->ignore($post)],
            "image" => ["nullable", "image", "max:2048", "mimes:png,jpeg,jpg"],
            "tags" => ["required"],
        ]);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->slug = Str::slug($request->slug);

        if($request->hasFile("image")){
            if($post->post_image){
                Storage::disk("post_public")->delete($post->post_image);
            }
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
        $post->status = $request->status;
        if(!auth()->user()->is_superuser){
            $post->status = "d";
        }
        $post->save();
        $tags = array_map('intval', $request->tags);
        $post->tags()->sync($tags);
        return redirect()->route("dashboard.panel");
    }
    
    function destroy(Post $post){
        $user = auth()->user();
        if($user->is_superuser || $user->id == $post->user->id){
            if($post->post_image && Storage::disk("post_public")->exists($post->post_image)){
                Storage::disk("post_public")->delete($post->post_image);
            }
            $post->delete();
            return redirect()->route("dashboard.panel");
        }
        return abort(404);
    }
}
