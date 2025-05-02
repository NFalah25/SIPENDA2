<form class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <div class="navbar-brand tw-flex tw-items-center">
        <span class="tw-block md:tw-hidden">SIPENDA</span>
        <span class="tw-hidden md:tw-block">Sistem Informasi Pensiun Digital & Arsip</span>
    </div>

</form>

<ul class="navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" data-toggle="dropdown"
            class="nav-link dropdown-toggle nav-link-md nav-link-user tw-flex tw-items-center ">
            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block"> @auth
                    {{ Auth::user()->name }}
                @endauth </div>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{route('profile')}}" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item has-icon text-danger"
                onclick="event.preventDefault();
                              document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
            <form action="{{ route('logout') }}" id="logout-form" method="POST">
                @csrf
            </form>
        </div>
    </li>
</ul>
