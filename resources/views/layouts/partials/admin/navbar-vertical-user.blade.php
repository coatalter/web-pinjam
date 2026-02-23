<!-- Sidebar -->
<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('admin_assets/images/brand/logo/logo.svg') }}" alt="" />
        </a>

        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            @foreach(($dynamicMenus ?? collect()) as $menu)
                @include('layouts.partials.admin.menu-item', ['menu' => $menu])
            @endforeach
        </ul>
    </div>
</nav>
