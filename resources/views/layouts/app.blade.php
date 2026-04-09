<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel CMS')</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

    @include('partials.header')
    
    @if(session('success'))
        <div class="container">
            <div class="alert">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <main class="main">
        <div class="container">
            @yield('content')
        </div>  
    </main>


    @include('partials.footer')
   
    
</body>
</html>