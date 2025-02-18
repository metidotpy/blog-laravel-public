@extends("dashboard.app")

@section("body")

<section class="tab-components">
    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">

        <!-- end row -->
        </div>
        <!-- ========== title-wrapper end ========== -->

        <!-- ========== form-elements-wrapper start ========== -->
        <div class="form-elements-wrapper">
        <div class="row">
            <div class="col-lg-12">
            <!-- input style start -->
            <div class="card-style mb-30">
                @include("dashboard.errors")
                <h6 class="mb-25">Post</h6>
                <form action="{{ route("blog.update", $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="input-style-1">
                        <label>Post Image</label>
                        <input name="image" type="file" />
                        @if($post->post_image)
                            <img src="{{ url($post->post_image) }}" alt="{{ $post->title }}" width="150">
                        @endif
                    </div>
                    <div class="input-style-1">
                    <label>Post Title</label>
                    <input value="{{ old("title", $post->title) }}" name="title" type="text" placeholder="Post Title..." />
                    </div>
                    <div class="input-style-1">
                    <label>Slug</label>
                    <input value="{{ old("slug", $post->slug) }}" name="slug" type="text" placeholder="Slug..." />
                    </div>
                    <div class="select-style-1">
                    <label>Category</label>
                    <div class="select-position">
                        <select name="tags[]" multiple class="form-control">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $tag->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    </div>

                    <div class="input-style-1">
                    <label>Content</label>
                    <textarea name="content" placeholder="Content..." id="myRichTextbox" rows="5">{{ old('content', $post->content) }}</textarea>
                    </div>
                    @if (auth()->user()->is_superuser)
                    <div class="select-style-1">
                    <label>Status</label>
                    @if(auth()->user()->is_superuser)
                        <div class="select-position">
                            <select name="status">
                                <option value="d" {{ old('status', $post->status ?? 'p') == 'd' ? 'selected' : ''}}>Draft</option>
                                <option value="p" {{ old('status', $post->status ?? 'p') == 'p' ? 'selected' : ''}}>Publish</option>
                            </select>
                        </div>
                    @else
                        <div disabled class="select-position">
                            <select name="status" class=" bg-black color-white">
                                <option value="d" {{ old('status', $post->status ?? 'p') == 'd' ? 'selected' : ''}}>Draft</option>
                                <option value="p" {{ old('status', $post->status ?? 'p') == 'p' ? 'selected' : ''}}>Publish</option>
                            </select>
                        </div>
                    </div>
                    @endif
                    @endif
                    <br> <br>
                    <div class="text-center">
                        <button type="submit" class="main-btn primary-btn rounded-full btn-hover">Update</button>
                    </div>
                </form>
                </div>
            </div>
            <!-- end card -->
            <!-- ======= input style end ======= -->

        <!-- end row -->
        </div>
        <!-- ========== form-elements-wrapper end ========== -->
    </div>
    <!-- end container -->
</section>

@endsection

@push("scripts")
<script>
    tinymce.init({
        selector: '#myRichTextbox',
        height: 500,
        menubar: false,
        plugins: [
        // Core editing features
        'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
        // Your account includes a free trial of TinyMCE premium features
        // Try the most popular premium features until Feb 24, 2025:
        'checklist', 'mediaembed', 'casechange', 'export', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'mentions', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown','importword', 'exportword', 'exportpdf',
      ],
        forced_root_block: '', // Prevents auto-wrapping in <p>
        entity_encoding: 'raw', // Prevents encoding special characters
        valid_elements: '*[*]', // Allows all elements & attributes
        cleanup: false, // Disables TinyMCE auto-cleanup
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',

      });
</script>
@endpush
