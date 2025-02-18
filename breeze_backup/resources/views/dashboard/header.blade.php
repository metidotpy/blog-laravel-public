<header class="header">
    <div class="container-fluid">
        <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <div class="header-right">
            <!-- profile start -->
            <div class="profile-box ml-15">
                <button class="dropdown-toggle bg-transparent border-0" type="button" id="profile"
                data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-info">
                    <div class="info">
                    <div class="image">
                        <img src="{{  url(auth()->user()->avatar_path) }}" alt="" />
                    </div>
                    <div>
                        <h6 class="fw-500">{{ auth()->user()->first_name . " " . auth()->user()->last_name }}</h6>
                        @if (auth()->user()->is_superuser)
                        <p>Admin</p>
                        @else
                            <p>Author</p>
                        @endif
                    </div>
                    </div>
                </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profile">
                <li>
                    <div class="author-info flex items-center !p-1">
                    <div class="image">
                        <img src="{{  url(auth()->user()->avatar_path) }}" alt="image">
                    </div>
                    <div class="content">
                        <h4 class="text-sm">{{ auth()->user()->username }}</h4>
                        <a class="text-black/40 dark:text-white/40 hover:text-black dark:hover:text-white text-xs" href="#">{{ auth()->user()->email }}</a>
                    </div>
                    </div>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ route('profile.edit') }}">
                    <i class="lni lni-user"></i> View Profile
                    </a>
                </li>
                <li>
                    <a href="#0"> <i class="lni lni-label-list"></i> Articles </a>
                </li>
                <li class="divider"></li>
                <li>
                    <form id="logoutBtn" action="{{ route("logout") }}" method="POST">
                        @csrf
                        <a id="logout" type="submit"> <i class="lni lni-exit"></i> Sign Out </a>
                    </form>
                </li>
                </ul>
            </div>
            <!-- profile end -->
            </div>
        </div>
        </div>
    </div>
    </header>

    @push("scripts")
    <script>
        let form = document.querySelector("#logoutBtn")
        let btn = document.querySelector("#logout")
        btn.addEventListener("click", () => {
            form.submit();
        })
    </script>
    @endpush
