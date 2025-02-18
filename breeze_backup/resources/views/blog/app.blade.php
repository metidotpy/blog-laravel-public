<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Simple Blog</title>
    <link rel="stylesheet" href="{{ asset("assets/blog/style.css") }}">
</head>
<body>
    @include("blog.nav")

    <main>
        @yield("body")

            <!-- Pagination -->
        @yield("pagination")
    </main>

    @include("blog.footer")

    <script src="{{ asset("assets/blog/script.js") }}"></script>
</body>
</html>
