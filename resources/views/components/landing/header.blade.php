<!-- header section strats -->
<header class="header_section">
    <div class="header_bottom">
        <div class="container-fluid">
        <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/irenta_hub_logo.png') }}" alt="iRENTA HUB Logo" class="logo navbar-brand-img mr-2 rounded-circle" style="height: 40px;" />
                <span class="font-weight-bold">iRENTA HUB</span>
            </a>
            {{-- <a class="navbar-brand" href="index.html">
                <img src="{{ asset('assets/images/irenta_hub_logo.png') }}" alt="iRENTA HUB Logo" class="logo navbar-brand-img" />
                <span>
                    iRENTA HUB
                </span>
            </a> --}}

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav  ">
                <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('home') }}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item {{ request()->routeIs('galleries') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('galleries') }}">Galleries</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="about.html"> About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.html">Contact Us</a>
                </li> --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.signin') }}"> <i class="fa-regular fa-user"></i> Sign In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('auth.signup') }}"> <i class="fa-solid fa-arrow-right-to-bracket"></i> Sign Up</a>
                    </li>
                    @endguest
                @auth
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('app') }}"> <i class="fa-solid fa-home"></i></a>
                    </li>
                @endauth
            </ul>
            </div>
        </nav>
        </div>
    </div>
</header>
<!-- end header section -->