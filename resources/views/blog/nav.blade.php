<header>
    <nav>
        <div class="logo"><a style="text-decoration: none; color: #fff;" href="{{ route('blog.index') }}">Blog</a></div>
        <!-- Burger menu icon -->
        <div class="menu-toggle" onclick="toggleNav()">&#9776;</div>

        <ul class="nav-links">
            <li><a href="{{ route("blog.index") }}">Home</a></li>
            <li class="dropdown">
                <a href="#">Tags</a>
                <ul class="dropdown-content">
                    @foreach($tags as $tag)
                        <li><a href="{{ route("tag.detail", $tag->slug) }}">{{ $tag->name }}</a></li>
                    @endforeach
                </ul>
            </li>
            @if(auth()->user())
                <li><a href="{{ route("dashboard.panel") }}">Dashboard</a></li>
                <li>
                    <form id="logoutBtn" action="{{ route("logout") }}" method="POST">
                    @csrf
                    <a style="cursor: pointer" id="logout" type="submit">Logout</a>
                </form>
            </li>
            @else
                <li><a href="{{ route("login") }}">Login</a></li>
                <li><a href="{{ route("register") }}">Register</a></li>
            @endif
        </ul>
    </nav>
</header>
