<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        {{-- <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div> --}}
        <div class="sidebar-brand-text mx-3">iRENTA HUB</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <h1 class="nav-link tw-text-xl" >{{ auth()->user()->organisation->org_name }}</h1>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Organization Interface
    </div>

    <li class="nav-item {{ request()->is('org') || request()->routeIs('org.index') ? 'active' : '' }}">
        <a class="nav-link py-2 " href="{{ route('org.index') }}">
          <i class="fa-solid fa-house"></i><span>Dashboard</span>
        </a>
   
    </li>
    

    <div class="sidebar-heading mt-3">
        Services
    </div>
    
    {{-- VEHICLES --}}
    <li class="nav-item {{ (request()->is('org/vehicles/*') || request()->routeIs('org.vehicles.index') ? 'active' : '') }}">
        <a class="nav-link py-2 collapsed" href="#" data-toggle="collapse" data-target="#collapseRoutes" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-car"></i><span>Vehicle Rentals</span>
        </a>
        <div id="collapseRoutes" class="collapse 
        {{ (request()->is('org/vehicles/*') || request()->routeIs('org.vehicles.index') ? 'show' : '') }}" 
         aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item {{ request()->routeIs('org.vehicles.category.index') ? 'active' : '' }}" href="{{ route('org.vehicles.category.index') }}">Categories</a>
                <a class="collapse-item {{ request()->routeIs('org.vehicles.index') ? 'active' : '' }}" href="{{ route('org.vehicles.index') }}">Vehicles</a>
                <a class="collapse-item {{ request()->routeIs('org.additional-rates.index') || request()->is('org/vehicles/additional-rates/*') ? 'active' : '' }}" href="{{ route('org.additional-rates.index') }}">Additional Rates</a>
            </div>
        </div>
    </li>

    {{-- PACKAGES --}}
    <li class="nav-item {{ request()->is('org/packages/*') || request()->routeIs('org.packages.index') ? 'active' : '' }}">
        <a class="nav-link py-2" href="{{ route('org.packages.index') }}">
          <i class="fa-solid fa-box"></i><span>Packages</span>
        </a>
    </li>

    {{-- D2D --}}
    <li class="nav-item 
        {{ (request()->is('org/routes/*') 
        || request()->routeIs('org.routes.index')  
        || request()->is('org/d2d-vehicles/*') 
        || request()->routeIs('org.d2d-vehicles.index') ? 'active' : '') }}
     ">
        <a class="nav-link py-2 collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-map-marked-alt"></i><span>Door to Door</span>
            </a>
        <div id="collapseTwo" class="collapse {{ (request()->is('org/routes/*') 
            || request()->routeIs('org.routes.index')  
            || request()->is('org/d2d-vehicles/*') 
            || request()->routeIs('org.d2d-vehicles.index') ? 'show' : '') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item {{ request()->routeIs('org.routes.index') ? 'active' : '' }}" href="{{ route('org.routes.index') }}">Routes</a>
                <a class="collapse-item {{ request()->routeIs('org.d2d-vehicles.index') ? 'active' : '' }}" href="{{ route('org.d2d-vehicles.index') }}">Vehicles</a>
            </div>
        </div>
    </li>


    <div class="sidebar-heading mt-3">
        Manage Bookings
    </div>
    
    <li class="nav-item {{ request()->is('org/bookings/*') || request()->routeIs('org.bookings.index') ? 'active' : '' }}">
        <a class="nav-link py-2" href="{{ route('org.bookings.index') }}">
            <i class="fa-solid fa-book"></i><span>Bookings</span>
        </a>
    </li>
    
    <li class="nav-item  {{ request()->is('org/refunds/*') || request()->routeIs('org.refunds.index') ? 'active' : '' }}">
        <a class="nav-link py-2" href="{{ route('org.refunds.index') }}">
            <i class="fa-solid fa-undo"></i><span>Refunds</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('org.cancellation-rates.index') || request()->is('org/cancellation-rates/*') ? 'active' : '' }}">
        <a class="nav-link py-2" href="{{ route('org.cancellation-rates.index') }}">
            <i class="fa-solid fa-percent"></i><span>Cancellation Rates</span>
        </a>
    </li>
    
    <li class="nav-item {{ request()->routeIs('org.reports.collections') || request()->routeIs('org.reports.refunds') || request()->routeIs('org.reports.cancellations') ? 'active' : '' }}">
        <a class="nav-link py-2 collapsed" href="#" data-toggle="collapse" data-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports">
            <i class="fa-solid fa-chart-pie"></i><span>Reports</span>
        </a>
        <div id="collapseReports" class="collapse {{ request()->routeIs('org.reports.collections') || request()->routeIs('org.reports.refunds') || request()->routeIs('org.reports.cancellations') ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                <a class="collapse-item {{ request()->routeIs('org.reports.collections') ? 'active' : '' }}" href="{{ route('org.reports.collections') }}">
                    Payment Collections
                </a>
                <a class="collapse-item {{ request()->routeIs('org.reports.refunds') ? 'active' : '' }}" href="{{ route('org.reports.refunds') }}">
                    Refunds List
                </a>
                <a class="collapse-item {{ request()->routeIs('org.reports.cancellations') ? 'active' : '' }}" href="{{ route('org.reports.cancellations') }}">
                    Cancellation List
                </a>
            </div>
        </div>
    </li>

  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->