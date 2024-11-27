<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
      {{-- <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
      </div> --}}
      <div class="sidebar-brand-text mx-3">iRENTA HUB</div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
      <a class="nav-link" href="#"><span>Admin Interface</span></a>
  </li>

    <li class="nav-item {{ request()->is('admin/galleries/*') || request()->routeIs('admin.galleries.index') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.galleries.index') }}">
        <i class="fa-solid fa-photo-video"></i><span>Galleries</span>
        </a>
    </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Nav Item - Pages Collapse Menu -->
  <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i><span>User Accounts</span>
      </a>
      <div id="collapseTwo" class="collapse {{ (request()->is('admin/*') ? 'show' : '') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
              {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
              <a class="collapse-item {{ request()->routeIs('admin.clients') ? 'active' : '' }}" href="{{ route('admin.clients') }}">Clients</a>
              <a class="collapse-item {{ request()->routeIs('admin.orgs') ? 'active' : '' }}" href="{{ route('admin.orgs') }}">Organizations</a>
          </div>
      </div>
  </li>

  <li class="nav-item {{ (request()->is('admin/inquiries/*') || request()->routeIs('admin.inquiries.index') ? 'active' : '') }}" >
      <a class="nav-link " href="{{ route('admin.inquiries.index') }}"  aria-expanded="true" >
        <i class="fas fa-fw fa-envelope"></i>
        <span>Inquiries</span>
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