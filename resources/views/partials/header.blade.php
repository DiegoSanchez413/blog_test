<div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
        <h5 class="text-white h4">Collapsed content</h5>
        <span class="text-muted">Toggleable via the navbar brand.</span>
    </div>
</div>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top bg-light navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">Blog</a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto align-items-center">
                @guest
                <li class="nav-item">
                    <a class="nav-link mx-2" href="{{route('register')}}"><i class="fas fa-heart pe-2"></i>Registrarse</a>
                </li>
                <li class="nav-item ms-3">
                    <a class="btn btn-black btn-rounded" href="{{route('login')}}">Iniciar sesión</a>
                </li>
                @else

                <li class="nav-item ms-3">
                    <a class="btn btn-black btn-rounded" href="{{route('user.logout')}}">Cerrar sesión</a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- Navbar -->