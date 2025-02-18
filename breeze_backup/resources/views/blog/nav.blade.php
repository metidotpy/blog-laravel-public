<header>
    <nav>
        <div class="logo">My Blog</div>
        <!-- Burger menu icon -->
        <div class="menu-toggle" onclick="toggleNav()">&#9776;</div>

        <ul class="nav-links">
            <li><a href="#">Home</a></li>
            <li class="dropdown">
                <a href="#">Tags</a>
                <ul class="dropdown-content">
                    <li><a href="#">Technology</a></li>
                    <li><a href="#">Lifestyle</a></li>
                    <li><a href="#">Health</a></li>
                </ul>
            </li>
            @if(auth()->user())
                <li><a href="{{ route("dashboard.panel") }}">Dashboard</a></li>
            @else
                <li><a href="{{ route("login") }}">Login</a></li>
                <li><a href="{{ route("register") }}">Register</a></li>
            @endif
        </ul>
    </nav>
</header>
