<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel CMS')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <div class="nav">
        <a href="{{ route('articles.index') }}">Frontend</a>
        {{-- <a href="{{ route('admin.articles.index') }}">Admin</a> --}}
        {{-- <a href="{{ route('admin.articles.create') }}">Neue Artikle</a> --}}
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')
    
</body>
</html>