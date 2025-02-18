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
                <h6 class="mb-25">Tag</h6>
                <form action="{{ route("tag.store") }}" method="POST">
                    @csrf

                    <div class="input-style-1">
                    <label>Tag Name</label>
                    <input value="{{ old("name") }}" name="name" type="text" placeholder="Tag Name..." />
                    </div>
                    <div class="input-style-1">
                    <label>Slug</label>
                    <input value="{{ old("slug") }}" name="slug" type="text" placeholder="Slug..." />
                    </div>
                    <br> <br>
                    <div class="text-center">
                        <button type="submit" class="main-btn primary-btn rounded-full btn-hover">Create</button>
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