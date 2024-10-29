<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="{{('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('public/logo.jpeg')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('public/logo.jpeg')}}" alt="" height="50"> <span class="logo-txt">Stay Real</span>
                    </span>
                </a>

                <a href="{{('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('public/logo.webp')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('public/logo.webp')}}" alt="" height="50"> <span class="logo-txt">Stay Real</span>
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                <i class="fa fa-fw fa-bars"></i>
            </button>

            <!-- App Search-->
            <form class="app-search d-none d-lg-block">
                <div class="position-relative">
                    <input type="text" class="form-control" placeholder="Search">
                    <button class="btn btn-success" type="button"><i class="bx bx-search-alt align-middle"></i></button>
                </div>
            </form>
        </div>

        <div class="d-flex">       

            <div class="dropdown d-none d-sm-inline-block">
                <button type="button" class="btn header-item" id="mode-setting-btn">
                    <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                    <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                </button>
            </div>

          

            <!-- <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item right-bar-toggle me-2">
                    <i data-feather="settings" class="icon-lg"></i>
                </button>
            </div> -->

            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item topbar-light bg-light-subtle border-start border-end" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{Auth()->user()->profile_pic == null ? asset('public/admin/assets/images/users/profile.png'): asset(Auth()->user()->profile_pic)}}" alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1 fw-medium">{{Auth::user()->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="javascript:0"><i class="mdi mdi-face-man font-size-16 align-middle me-1"></i>Profile</a>
                    <a class="dropdown-item" href="{{url('forgot-password')}}">
                        <i class="mdi mdi-lock font-size-16 align-middle me-1"></i>
                      Reset Password
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <i class="mdi mdi-logout me-1 mdi-20px"></i> {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>