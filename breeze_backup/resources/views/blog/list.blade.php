@extends("blog.app")

@section("body")
<div class="blog-posts">
    <!-- Post 1 -->
    @foreach ($posts as $post)
        <div class="post">
            <img src="{{ url($post->post_image) }}" alt="Post Image">
            <h2><a href="detail.html?id=1">{{ $post->title }}</a></h2>
            <div class="author">
                <!-- Author avatar and name -->
                <img class="author-avatar" style="border-radius: 50%" src="{{ url($post->user->avatar_path) }}" alt="Author Avatar">
                <span>Author: {{ $post->user->username }}</span>
            </div>
            <p class="summary">{{ Str::limit($post->content, 50, $end= "...") }}</p>
            <div class="tags">
                @foreach($post->tags as $tag)
                    <a href="">#{{ $tag->name }}</a>
                @endforeach
            </div>
            <a href="detail.html?id=1">Read more</a>
        </div>
    @endforeach
    </div>
@endsection


@section("pagination")
<div class="pagination">
    <a href="#">1</a>
    <a href="#">2</a>
    <a href="#">Next</a>
</div>
@endsection
