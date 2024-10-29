<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" data-key="t-menu">Dashboard Menu</li>
              

                <li>
                    <a href="{{ url('dashboard') }}">
                        <i data-feather="home"></i>
                        <span data-key="">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow">
                        <i data-feather="users"></i>
                        <span data-key="t-guest">User Information</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                       
                        <li><a href="{{ url('admin/users') }}" data-key="t-login">Users</a></li>         
                        
                    </ul>
                </li>

               
              </ul>
             
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->