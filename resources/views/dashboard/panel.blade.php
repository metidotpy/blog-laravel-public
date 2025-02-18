@extends("dashboard.app")
@section("body")
<section class="section">
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this post?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    
                    <!-- Delete Form (Dynamically Set Action with JavaScript) -->
                    <form id="deleteFormTag" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center gap-4">
                @if (auth()->user()->is_superuser)

                <div class="col-lg-12">

                    <div class="card-style mb-30">
                    <div class="title">
                        <h2>Users</h2>
                    </div>
                    <div class="table-wrapper table-responsive text-center">
                        <table class="table table-responsive gap-4">
                        <thead class="text-center">
                            <tr>
                            <th>
                                <h6>#</h6>
                            </th>
                            <th>
                                <h6>Full Name</h6>
                            </th>
                            <th>
                                <h6>Username</h6>
                            </th>
                            <th>
                                <h6>Email</h6>
                            </th>
                            <th>
                                <h6>Status</h6>
                            </th>
                            <th>
                                <h6>Posts Count</h6>
                            </th>
                            <th>
                                <h6>Action</h6>
                            </th>
                            </tr>
                            <!-- end table row-->
                        </thead>
                        <tbody class="text-center gap-4">
                            @foreach ($users as $user)

                            <tr>
                                <td class="p-3">
                                <div class="employee-image m-auto">
                                    <img class="center" src="{{  url($user->avatar_path ) }}" alt="{{ $user->username }}" />
                                </div>
                                </td>
                                <td class="min-width p-3">
                                <p>{{ $user->first_name . " " . $user->last_name }}</p>
                                </td>
                                <td class="min-width p-3">
                                <p>{{ $user->username }}</p>
                                </td>
                                <td class="min-width p-3">
                                <p>{{ $user->email }}</p>
                                </td>
                                <td class="min-width p-3">
                                @if($user->email_verified_at)
                                    <span class="status-btn active-btn">Active</span>
                                @else
                                    <span class="status-btn warning-btn">Deactive</span>
                                @endif
                                </td>
                                <td class="min-width p-3">
                                    <p>{{ $user->posts->count() }}</p>
                                </td>
                                <td class="p-3">
                                <div class="action">
                                    <button class="text-danger m-auto">
                                    <i class="lni lni-trash-can"></i>
                                    </button>
                                    <button class="text-danger m-auto">
                                    <i class="lni lni-upload"></i>
                                    </button>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
            </div>
        @endif
        </div>
    </div>
            <div class="col-lg-12">
            <div class="card-style mb-30">
                <div class="title d-flex justify-content-between align-items-center">
                    <h2>Posts</h2>
                    <a class="btn btn-primary mx-4" href="{{ route("blog.create") }}">New Post</a>
                </div>
                <div class="table-wrapper table-responsive text-center">
                <table class="table table-responsive  gap-4">
                    <thead class="text-center">
                    <tr>
                        <th>
                        <h6>Post Image</h6>
                        </th>
                        <th>
                        <h6>Title</h6>
                        </th>
                        <th>
                        <h6>Slug</h6>
                        </th>
                        <th>
                        <h6>Author</h6>
                        </th>
                        <th>
                        <h6>Status</h6>
                        </th>
                        <th>
                        <h6>Action</h6>
                        </th>
                    </tr>
                    <!-- end table row-->
                    </thead>
                    <tbody class="text-center gap-4">
                        @if (auth()->user()->is_superuser)

                        @foreach ($posts as $post)
                        <tr>
                            <td class="p-3">
                                <div class="employee-image m-auto">
                                <img class="center" src="{{ url($post->post_image) }}" alt="{{ $post->title }}" />
                                </div>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->title }}</p>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->slug }}</p>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->user->username }}</p>
                            </td>
                            <td class="min-width p-3">
                                @if($post->status == 'p')
                                    <span class="status-btn active-btn">Published</span>
                                @else
                                    <span class="status-btn warning-btn">Draft</span>
                                @endif

                            </td>
                            <td class="p-3">
                                <div class="action">
                                    <a style="cursor: pointer" href="javascript:;" onclick="if(confirm('Are you sure you want to delete this post?')) document.getElementById('post-{{ $post->id }}').submit()" class="text text-danger m-auto">
                                        <i class="lni lni-trash-can"></i>
                                    </a>
                                <form method="POST" action="{{ route('blog.delete', $post->id) }}" id="post-{{$post->id}}">
                                    @csrf
                                    @method("DELETE")
                                </form>
                                @if($post->status == "d")
                                <a href="{{ route("blog.preview", [$post->slug]) }}" class="text-danger m-auto">
                                    <i class="lni lni-upload"></i>
                                </a>
                                @elseif ($post->status == "p")
                                <a href="{{ route("blog.detail", [$post->slug]) }}" class="text-danger m-auto">
                                    <i class="lni lni-upload"></i>
                                </a>
                                @endif
                                <a href="{{ route("blog.edit", [$post->id]) }}" class="text-danger m-auto">
                                    <i class="lni lni-paperclip"></i>
                                </a>
                                </div>
                            </td>
                            </tr>
                        @endforeach
                        @else
                        @foreach (auth()->user()->posts as $post)
                        <tr>
                            <td class="p-3">
                                <div class="employee-image m-auto">
                                <img class="center" src="{{ url($post->post_image) }}" alt="{{ $post->title }}" />
                                </div>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->title }}</p>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->slug }}</p>
                            </td>
                            <td class="min-width p-3">
                                <p>{{ $post->user->username }}</p>
                            </td>
                            <td class="min-width p-3">
                                @if($post->status == 'p')
                                    <span class="status-btn active-btn">Published</span>
                                @else
                                    <span class="status-btn warning-btn">Draft</span>
                                @endif

                            </td>
                            <td class="p-3">
                                <div class="action">
                                <a style="cursor: pointer" href="javascript:;" onclick="if(confirm('Are you sure you want to delete this post?')) document.getElementById('post-{{ $post->id }}').submit()" class="text text-danger m-auto">
                                    <i class="lni lni-trash-can"></i>
                                </a>
                                <form method="POST" action="{{ route('blog.delete', $post->id) }}" id="post-{{$post->id}}">
                                    @csrf
                                    @method("DELETE")
                                </form>
                                <a href="@if($post->status == 'd'){{ route("blog.preview", $post->slug) }} @else {{ route("blog.detail", $post->slug) }} @endif" class="text-danger m-auto">
                                    <i class="lni lni-upload"></i>
                                </a>
                                <a href="{{ route("blog.edit", [$post->id]) }}" class="text-danger m-auto">
                                    <i class="lni lni-paperclip"></i>
                                </a>
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
        </div>
        </div>
        @if(auth()->user()->is_superuser)
        <div class="col-lg-12">
        <div class="card-style mb-30">
            <div class="title d-flex justify-content-between align-items-center">
                <h2>Tags</h2>
                <a class="btn btn-primary mx-4" href="{{ route("tag.create") }}">New Tag</a>
            </div>
            <div class="table-wrapper table-responsive text-center">
            <table class="table table-responsive  gap-4">
                <thead class="text-center">
                <tr>
                    <th>
                    <h6>Name</h6>
                    </th>
                    <th>
                    <h6>Slug</h6>
                    </th>
                    <th>
                    <h6>Posts Count</h6>
                    </th>
                    <th>
                    <h6>Action</h6>
                    </th>
                </tr>
                <!-- end table row-->
                </thead>
                <tbody class="text-center gap-4">
                    @foreach ($tags as $tag)
                    <tr>
                        <td class="min-width p-3">
                            <p>{{ $tag->name }}</p>
                        </td>
                        <td class="min-width p-3">
                            <p><a href="{{ route("tag.detail", $tag->slug) }}">#{{ $tag->slug }}</a></p>
                        </td>
                        <td class="min-width p-3">
                            <span>{{ $tag->posts->count() }}</span>
                        </td>
                        <td class="p-3">
                            <div class="action">
                                <a href="javascript:;" onclick="if(confirm('Are you sure you want to delete this tag?')) document.getElementById('form-{{ $tag->id }}').submit()" class="text text-danger m-auto">
                                    <i class="lni lni-trash-can"></i>
                                    <form hidden id="form-{{ $tag->id }}" action="{{ route("tag.delete", $tag->id) }}" method="post">
                                        @csrf
                                        @method("DELETE")
                                    </form>
                                </a>
                                <a href="{{ route("tag.detail", $tag->slug) }}" class="text-primary m-auto">
                                    <i class="lni lni-upload"></i>
                                </a>
                                <a href="{{ route("tag.edit", [$tag->id]) }}" class="text-warning mx-auto">
                                    <i class="lni lni-paperclip"></i>
                                </a>
                            </div>
                        </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
    </div>
    </div>
    @endif
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="title">
                    <h2>Calender</h2>
                    </div>
                </div>
                <div class="card-style calendar-card mb-30 mt-2">
                    <div id="calendar-mini"></div>
                </div>
                </div>
                </div>
        </div>
        <!-- End Col -->

    </div>
</div>
        <!-- End Row -->
    </div>
    <!-- end container -->
    </section>

@endsection
@push("scripts")
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var deleteModal = document.getElementById("deleteModal");

        deleteModal.addEventListener("show.bs.modal", function (event) {
            // event.preventDefault();
            var button = event.relatedTarget;  // Button that triggered the modal
            console.log(button);
            // event.preventDefault()
            var postId = button.getAttribute("data-id");  // Get the post ID
            
            // Set the form action dynamically
            var deleteForm = document.getElementById("post-" + postId);
            deleteForm.submit();
        });

    });

    function confirmDeleteTag(){
        // event.preventDefault();
        if(confirm("Are you sure you want to delete this tag?")){
            document.getElementById("deleteFormTag").submit();
        }
        
        
    }
</script>
@endpush
