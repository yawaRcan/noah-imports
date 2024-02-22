<!-- ============================================================== -->
<!-- Topbar header - style you can find in pages.scss -->
<!-- ============================================================== -->
<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-sm navbar-dark">
        {{-- <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="index.html">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{(!isset(general_setting('company')->logo)) ? asset('assets/images/logo-icon.png'):asset('storage/assets/company/logo.png')}}" width="40px" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{(!isset(general_setting('company')->logo)) ? asset('assets/images/logo-icon.png'):asset('storage/assets/company/logo.png')}}" width="40px" alt="homepage" class="light-logo" />
                    <!-- <img src="../assets/images/logo-light-icon.png" alt="homepage" class="" /> -->
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                    {{(!isset(general_setting('configuration')->site_name) ) ? 'Noah Imports' : general_setting('configuration')->site_name}}
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                    class="ti-more"></i></a>
        </div> --}}
        <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none  d-flex  resposiveToggler" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand resposiveBrand" href="index.html">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <img src="{{(!isset(general_setting('company')->logo)) ? asset('assets/images/logo-icon.png'):asset('storage/assets/company/logo.png')}}" width="40px" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="{{(!isset(general_setting('company')->logo)) ? asset('assets/images/logo-icon.png'):asset('storage/assets/company/logo.png')}}" width="40px" alt="homepage" class="light-logo" />
                    <!-- <img src="{{asset('assets/images/logo-light-icon.png')}}" alt="homepage" class="" /> -->
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->
                <span class="logo-text">
                    {{(!isset(general_setting('configuration')->site_name) ) ? 'Noah Imports' : general_setting('configuration')->site_name}}
                </span>
            </a>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Toggle which is visible on mobile only -->
            <!-- ============================================================== -->
            <a class="topbartoggler d-block d-sm-none waves-effect waves-light" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav me-auto">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark"
                        href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav">
                <!-- ============================================================== -->
                <!-- Comment -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell"></i>
                        @if(count(Auth::user()->unreadNotifications) > 0)
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-end mailbox dropdown-menu-animate-up">
                        <ul class="list-style-none">
                            <li>
                                <div class="border-bottom rounded-top py-3 px-4">
                                    <div class="mb-0 font-weight-medium fs-4">Notifications ({{ count(Auth::user()->unreadNotifications) }})

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="message-center notifications position-relative" style="height:230px;">
                                    @if(count(Auth::user()->unreadNotifications) > 0)
                                    @foreach (Auth::user()->unreadNotifications as $notification) 
                                        @include('user.notifications.'.class_basename($notification->type))
                                    @endforeach

                                    @else
                                    <div class="text-muted text-center p-3">No Notification is available</div>
                                    @endif
                                </div>
                            </li>
                            <li>
                                <a class="nav-link border-top text-center text-dark pt-3 ni-notification-click-all-read" href="javascript:void(0);">
                                    <strong>Mark As All Read</strong> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Comment -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Profile -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="#"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{asset('assets/images/users/1.jpg')}}" alt="user" width="30"
                            class="profile-pic rounded-circle" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end user-dd animated flipInY">
                        <div class="d-flex no-block align-items-center p-3 bg-info text-white mb-2">
                            <div class=""><img src="{{asset('assets/images/users/1.jpg')}}" alt="user"
                                    class="rounded-circle" width="60"></div>
                            <div class="ms-2">
                                <h4 class="mb-0 text-white">{{Auth::user()->name}}</h4>
                                <p class=" mb-0">{{Auth::user()->email}}</p>
                            </div>
                        </div>
                        <a class="dropdown-item" href="{{route('user.account.index')}}"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>Edit Account</a>
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                    <button class="dropdown-item" href="#" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i data-feather="log-out"
                            class="feather-sm text-danger me-1 ms-1"></i> Logout</button>
                     </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- Language -->
                <!-- ============================================================== -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                            class="flag-icon flag-icon-us"></i></a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"> <a class="dropdown-item"
                            href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item"
                            href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item"
                            href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item"
                            href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a>
                    </div>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
<!-- ============================================================== -->
<!-- End Topbar header -->
<!-- ============================================================== -->
