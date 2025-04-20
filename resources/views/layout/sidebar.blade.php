<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">SIPENDA</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">SA</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li><a class="nav-link" href="{{ route('dashboard') }}"><i class="far fa-folder"></i> <span>Arsip Pensiun</span></a></li>
        @if (Auth::user()->role == 'admin')
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li><a class="nav-link" href="{{ route('unit.index') }}">Unit</a></li>
                </ul>
            </li>
            <li><a class="nav-link" href="{{ route('user.index') }}"><i class="far fa-user"></i> <span>Manajemen
                        User</span></a></li>
        @endif
    </ul>

</aside>
