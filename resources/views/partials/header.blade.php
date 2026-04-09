<div class="container">
    <header class="header">
        <a href="{{ route('articles.index') }}" class="header__logo">
            <img src="{{ asset('images/test-logo.png') }}" alt="My Laravel Site">
        </a>
        <nav class="header__nav nav">
            <ul class="nav__items">
                <li class="nav__item" ><a  href="{{ route('articles.index') }}">Frontend</a></li>
                @auth
                    <li class="nav__item"><a  href="{{ route('admin.articles.index') }}">Admin</a></li>
                    <li class="nav__item"> <a  href="{{ route('admin.articles.create') }}">Neue Artikle</a> </li>         
                @endauth
            </ul>
        </nav>
        <div class="header__buttons">
            @auth
            <form  action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-danger" style="padding: 8px 12px;">Logout</button>
            </form>
            @else
                <a href="{{ route('login') }}" class="btn">Login</a>
            @endauth
        </div>
    </header>
</div>
