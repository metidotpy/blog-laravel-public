<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $admin = User::create([
            "first_name"=>"Mehdi",
            "last_name"=> "Radfar",
            "username" => "funlife",
            "email" => "helloworldmetidotpy@gmail.com",
            "is_superuser"=>true,
            "email_verified_at" => now(),
            "password" => "12345678",
        ]);

        $normal_user = User::create([
            "first_name"=>"Arshia",
            "last_name"=> "Makvandi",
            "username" => "arshia",
            "email" => "arshia@gmail.com",
            "is_superuser"=>false,
            "email_verified_at" => now(),
            "password" => "12345678",
        ]);

        $unverified_user = User::create([
            "first_name"=>"Seyed Hossein",
            "last_name"=> "Siadatan",
            "username" => "hossein",
            "email" => "hossein@gmail.com",
            "password" => "12345678",
        ]);

        $tag1 = Tag::create([
            "name"=>"Science",
            "slug"=>"science",
        ]);
        $tag2 = Tag::create([
            "name"=>"Mathematics",
            "slug"=>"mathematics"
        ]);

        $post = Post::create([
            "author" => $admin->id,
            "title" => "First Post",
            "slug" => Str::slug("first-post"),
            "content" => "This post added by seeder",
            "status" => "p",
        ]);
        

        $post2 = Post::create([
            "author" => $normal_user->id,
            "title" => "Second Post by Arshia Makvandi",
            "slug" => Str::slug("second-post"),
            "content" => "This post added by Arshia Makvandi; A normal user",
            "status" => "d",
        ]);

        $post->tags()->sync([$tag1->id, $tag2->id]);
        $post->tags()->sync([$tag2->id]);
        
        
    }
}
