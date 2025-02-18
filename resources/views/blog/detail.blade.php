@extends("blog.app")


@section("body")
<div class="post-detail">
    <h1>{{ $post->title }}</h1>
    <div class="author">
        <!-- Author avatar and name -->
        <img style="border-radius: 50%; width: 50px; height: 50px; object-fit: cover;" class="author-avatar" src="{{ url($post->user->avatar_path) }}" alt="{{ $post->user->username }}">
        <span>{{ $post->user->username }}</span>
    </div>
    <p class="date">Published on {{ $post->created_at->format('Y, F jS') }}</p>
    <img src="{{ asset($post->post_image) }}" alt="Post Image">
    <p>{!! $post->content !!}</p>
    <div class="tags">
        @foreach($post->tags as $tag)
        <a href="{{ route("tag.detail", $tag->slug) }}">#{{ $tag->name }}</a>
        @endforeach
    </div>
</div>
@endsection
