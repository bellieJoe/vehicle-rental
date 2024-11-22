<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">iRENTA HUB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="#">Client Interface</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <li class="nav-item {{ request()->is('client/vehicles/*') || request()->routeIs('client.vehicles') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('client.vehicles') }}">
        <i class="fa fa-car"></i><span>Rent Vehicles</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('client/packages/*') || request()->routeIs('client.packages') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('client.packages') }}">
        <i class="fa-solid fa-map-location-dot"></i><span>Book Tour Packages</span>
        </a>
    </li>
    <li class="nav-item {{ request()->is('client/bookings/*') || request()->routeIs('client.bookings') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('client.bookings') }}">
            <i class="fa-solid fa-book"></i><span>My Bookings</span>
        </a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->