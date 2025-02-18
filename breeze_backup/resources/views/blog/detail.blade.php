@extends("blog.app")


@section("body")
<div class="post-detail">
    <h1>{{ $post->title }}</h1>
    <div class="author">
        <!-- Author avatar and name -->
        <img class="author-avatar" src="{{ url($post->author->avatar_image) }}" alt="{{ $post->author->username }}">
        <span>{{ $post->author->username }}</span>
    </div>
    <p class="date">Published on @date($post->created_at, 'Y, F jS')</p>
    <img src="{{ url($post->post_image) }}" alt="Post Image">
    <p>{!! $post->content !!}/p>
    <div class="tags">
        <a href="">#{{ $post->tag->name }}</a>
    </div>
</div>
@endsection
