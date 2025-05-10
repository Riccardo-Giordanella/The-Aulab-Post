<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}">The Aulab Post</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('article.index') }}" class="nav-link" aria-current="page">Tutti gli
                        articoli</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('careers') }}" class="nav-link" aria-current="page">Lavora con noi</a>
                </li>
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Ciao {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            @if (Auth::user()->is_admin)
                                <li><a href="{{ route('admin.dashboard') }}" class="dropdown-item">Dashboard Admin</a></li>
                            @endif
                            @if (Auth::user()->is_revisor)
                                <li><a href="{{ route('revisor.dashboard') }}" class="dropdown-item">Dashboard Revisor</a>
                                </li>
                            @endif
                            <li><a class="dropdown-item" href="#"
                                    onclick="event.preventDefault(); document.querySelector('#form-logout').submit();">Logout</a>
                            </li>
                            <form action="{{ route('logout') }}" method="POST" id="form-logout" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </li>
                    @if (Auth::user()->is_writer)
                        <li class="nav-item">
                            <a href="{{ route('article.create') }}" class="nav-link">Inserisci un articolo</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('writer.dashboard') }}" class="dropdown-item">Dashboard Writer</a>
                        </li>
                    @endif
                @endauth
                @guest
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Benvenuto Ospite
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('register') }}" class="dropdown-item">Registrati</a></li>
                            <li><a href="{{ route('login') }}" class="dropdown-item">Accedi</a></li>
                        </ul>
                    </li>
                @endguest
            </ul>
            <form action="{{ route('article.search') }}" method="GET" class="d-flex" role="search">
                <input class="form-control me-2" type="search" name="query" placeholder="Cerca tra gli articoli..."
                    aria-label="Search">
                <button class="btn btn-outline-secondary" type="submit">Cerca</button>
            </form>
        </div>
    </div>
</nav>
