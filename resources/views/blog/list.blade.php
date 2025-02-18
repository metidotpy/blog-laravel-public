@extends("blog.app")

@section("body")
<div class="blog-posts">
    
    @isset($posts)
    @if(isset($posts) && isset($tag))
        <h1 style="text-align: center; margin-bottom: 2rem;">"{{ $tag->name }}" Posts:</h1>
        <hr>
        <br> <br>
    @endif
    @forelse ($posts as $post)
        <div class="post">
            <img src="{{ url($post->post_image) }}" alt="Post Image">
            <h2><a href="{{ route("blog.detail", $post->slug) }}">{{ $post->title }}</a></h2>
            <div class="author">
                <!-- Author avatar and name -->
                <img class="author-avatar" style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;" src="{{ url($post->user->avatar_path) }}" alt="Author Avatar">
                <span>Author: {{ $post->user->username }}</span>
            </div>
            <p class="summary">{{ Str::limit(strip_tags($post->content), 30, $end= "...") }}</p>
            <div class="tags">
                @foreach($post->tags as $tag)
                    <a href="{{ route("tag.detail", $tag->slug) }}">#{{ $tag->name }}</a>
                @endforeach
            </div>
            <a href="{{ route("blog.detail", $post->slug) }}">Read more</a>
        </div>
        @empty
        <h1 style="text-align: center; margin-bottom: 2rem;">"There is no posts.</h1>
        @endforelse
    @endisset
    </div>
@endsection


@section("pagination")
<div class="pagination">
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#">Next</a>
</div>
@endsection
