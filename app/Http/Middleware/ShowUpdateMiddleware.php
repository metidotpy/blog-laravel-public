<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ShowUpdateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $post = Post::where("id", "=", $request->route("id"), "and")->where("author", "=", auth()->user()->id)->firstOrFail();
        if(auth()->user()->is_superuser){
            $post = Post::where("id", "=", $request->route("id"), "and")->firstOrFail();
        }
        if ($post){
            return $next($request);
        }
        return abort(404);
    }
}
