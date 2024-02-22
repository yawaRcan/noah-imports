<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, material admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, material design, material dashboard bootstrap 5 dashboard template">
    <meta name="description" content="MaterialPro is powerful and clean admin dashboard template, inpired from Google's Material Design">
    <meta name="robots" content="noindex,nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>  {{(!isset(general_setting('configuration')->site_name) ) ? 'Noah Imports' : general_setting('configuration')->site_name}}</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/materialpro/" />
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href=" {{(!isset(general_setting('company')->favicon) ) ? asset('assets/images/favicon.png') : asset('storage/assets/company/favicon.png')}}">
    <link rel="stylesheet" href="{{asset('assets/libs/apexcharts/dist/apexcharts.css')}}">
    <link href="{{asset('assets/libs/jvectormap/jquery-jvectormap.css')}}" rel="stylesheet">
    <link href="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet" /> 
    <link href="{{asset('assets/extra-libs/input-tel/css/intlTelInput.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="{{asset('assets/libs/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/quill/dist/quill.snow.css')}}">
    <!-- Custom CSS -->
    <link href="{{asset('css/style.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    
    @stack('head-script')

    <!-- HTML5 Shim and Respond.js')}} IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js')}} doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js')}}/1.4.2/respond.min.js')}}"></script>
<![endif]-->

    <style type="text/css">
    .invalid-feedback{
        position: absolute;
        top: 100%;
        z-index: 5;
        display: none;
        max-width: 100%;
        padding: 0.4rem 0.7rem;
        margin-top: 0.1rem;
        font-size: .71094rem;
        color: #fff;
        opacity: 0.8;
        background-color: rgba(236,83,108,.9);
        border-radius: 0.25rem;
    }
</style>


</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css')}} -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="tea lds-ripple" width="37" height="48" viewbox="0 0 37 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M27.0819 17H3.02508C1.91076 17 1.01376 17.9059 1.0485 19.0197C1.15761 22.5177 1.49703 29.7374 2.5 34C4.07125 40.6778 7.18553 44.8868 8.44856 46.3845C8.79051 46.79 9.29799 47 9.82843 47H20.0218C20.639 47 21.2193 46.7159 21.5659 46.2052C22.6765 44.5687 25.2312 40.4282 27.5 34C28.9757 29.8188 29.084 22.4043 29.0441 18.9156C29.0319 17.8436 28.1539 17 27.0819 17Z" stroke="#1e88e5" stroke-width="2"></path>
            <path d="M29 23.5C29 23.5 34.5 20.5 35.5 25.4999C36.0986 28.4926 34.2033 31.5383 32 32.8713C29.4555 34.4108 28 34 28 34" stroke="#1e88e5" stroke-width="2"></path>
            <path id="teabag" fill="#1e88e5" fill-rule="evenodd" clip-rule="evenodd" d="M16 25V17H14V25H12C10.3431 25 9 26.3431 9 28V34C9 35.6569 10.3431 37 12 37H18C19.6569 37 21 35.6569 21 34V28C21 26.3431 19.6569 25 18 25H16ZM11 28C11 27.4477 11.4477 27 12 27H18C18.5523 27 19 27.4477 19 28V34C19 34.5523 18.5523 35 18 35H12C11.4477 35 11 34.5523 11 34V28Z">
            </path>
            <path id="steamL" d="M17 1C17 1 17 4.5 14 6.5C11 8.5 11 12 11 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke="#1e88e5"></path>
            <path id="steamR" d="M21 6C21 6 21 8.22727 19 9.5C17 10.7727 17 13 17 13" stroke="#1e88e5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">

        @include('user.partials.header')

        @include('user.partials.left-side-bar')

        <main>
            <!-- Page wrapper  -->
            <!-- ============================================================== -->
            <div class="page-wrapper">
                @yield('content')
            </div>
            <!-- ============================================================== -->
            <!-- End Page wrapper  -->
            <!-- ============================================================== -->

        </main>

        @include('user.partials.footer')

    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- customizer Panel -->
    <!-- ============================================================== -->
    <aside class="customizer">
        <a href="javascript:void(0)" class="service-panel-toggle"><i class="fa fa-spin fa-cog"></i></a>
        <div class="customizer-body">
            <!-- <ul class="nav customizer-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true"><i class="mdi mdi-wrench fs-6"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#chat" role="tab" aria-controls="chat" aria-selected="false"><i class="mdi mdi-message-reply fs-6"></i></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="mdi mdi-star-circle fs-6"></i></a>
                </li>
            </ul> -->
            <div class="tab-content" id="pills-tabContent">
                <!-- Tab 1 -->
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="p-3 border-bottom">
                        <!-- Sidebar -->
                        <h5 class="font-weight-medium mb-2 mt-2">Layout Settings</h5>
                        <div class="form-check mt-3">
                            <input type="checkbox" name="theme-view" class="form-check-input" id="theme-view">
                            <label class="form-check-label" for="theme-view"> <span>Dark Theme</span> </label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" class="sidebartoggler form-check-input" name="collapssidebar" id="collapssidebar">
                            <label class="form-check-label" for="collapssidebar"> <span>Collapse Sidebar</span>
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="sidebar-position" class="form-check-input" id="sidebar-position">
                            <label class="form-check-label" for="sidebar-position"> <span>Fixed Sidebar</span>
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="header-position" class="form-check-input" id="header-position">
                            <label class="form-check-label" for="header-position"> <span>Fixed Header</span> </label>
                        </div>
                        <div class="form-check mt-2">
                            <input type="checkbox" name="boxed-layout" class="form-check-input" id="boxed-layout">
                            <label class="form-check-label" for="boxed-layout"> <span>Boxed Layout</span> </label>
                        </div>
                    </div>
                    <div class="p-3 border-bottom">
                        <!-- Logo BG -->
                        <h5 class="font-weight-medium mb-2 mt-2">Logo Backgrounds</h5>
                        <ul class="theme-color m-0 p-0">
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin1"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin2"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin3"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin4"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin5"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-logobg="skin6"></a></li>
                        </ul>
                        <!-- Logo BG -->
                    </div>
                    <div class="p-3 border-bottom">
                        <!-- Navbar BG -->
                        <h5 class="font-weight-medium mb-2 mt-2">Navbar Backgrounds</h5>
                        <ul class="theme-color m-0 p-0">
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin1"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin2"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin3"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin4"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin5"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-navbarbg="skin6"></a></li>
                        </ul>
                        <!-- Navbar BG -->
                    </div>
                    <div class="p-3 border-bottom">
                        <!-- Logo BG -->
                        <h5 class="font-weight-medium mb-2 mt-2">Sidebar Backgrounds</h5>
                        <ul class="theme-color m-0 p-0">
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin1"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin2"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin3"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin4"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin5"></a></li>
                            <li class="theme-item list-inline-item me-1"><a href="javascript:void(0)" class="theme-link rounded-circle d-block" data-sidebarbg="skin6"></a></li>
                        </ul>
                        <!-- Logo BG -->
                    </div>
                </div>
                <!-- End Tab 1 -->
                <!-- Tab 2 -->
                <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <ul class="mailbox list-style-none mt-3">
                        <li>
                            <div class="message-center chat-scroll position-relative">
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_1' data-user-id='1'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/1.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle online"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:30
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_2' data-user-id='2'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/2.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle busy"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Sonu Nigam</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">I've sung a
                                            song! See you at</span> <span class="fs-2 text-nowrap d-block text-muted">9:10 AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_3' data-user-id='3'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/3.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle away"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Arijit Sinh</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">I am a
                                            singer!</span> <span class="fs-2 text-nowrap d-block text-muted">9:08
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_4' data-user-id='4'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/4.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle offline"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Nirav Joshi</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:02
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_5' data-user-id='5'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/5.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle offline"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Sunil Joshi</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:02
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_6' data-user-id='6'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/6.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle offline"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Akshay Kumar</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:02
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_7' data-user-id='7'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/7.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle offline"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:02
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                                <!-- Message -->
                                <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2" id='chat_user_8' data-user-id='8'>
                                    <span class="user-img position-relative d-inline-block"> <img src="{{asset('assets/images/users/8.jpg')}}" alt="user" class="rounded-circle w-100">
                                        <span class="profile-status rounded-circle offline"></span> </span>
                                    <div class="w-75 d-inline-block v-middle ps-3">
                                        <h5 class="message-title mb-0 mt-1">Varun Dhavan</h5> <span class="fs-2 text-nowrap d-block text-muted text-truncate">Just see the my
                                            admin!</span> <span class="fs-2 text-nowrap d-block text-muted">9:02
                                            AM</span>
                                    </div>
                                </a>
                                <!-- Message -->
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- End Tab 2 -->
                <!-- Tab 3 -->
                <div class="tab-pane fade p-3" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <h6 class="mt-3 mb-3">Activity Timeline</h6>
                    <div class="steamline">
                        <div class="sl-item">
                            <div class="sl-left bg-light-success text-success">
                                <i data-feather="user" class="feather-sm fill-white"></i>
                            </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Meeting today <span class="sl-date"> 5pm</span></div>
                                <div class="desc">you can write anything </div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left bg-light-info text-info">
                                <i data-feather="camera" class="feather-sm fill-white"></i>
                            </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Send documents to Clark</div>
                                <div class="desc">Lorem Ipsum is simply </div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left"> <img class="rounded-circle" alt="user" src="{{asset('assets/images/users/2.jpg')}}"> </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Go to the Doctor <span class="sl-date">5 minutes
                                        ago</span>
                                </div>
                                <div class="desc">Contrary to popular belief</div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left"> <img class="rounded-circle" alt="user" src="{{asset('assets/images/users/1.jpg')}}"> </div>
                            <div class="sl-right">
                                <div><a href="javascript:void(0)">Stephen</a> <span class="sl-date">5 minutes
                                        ago</span>
                                </div>
                                <div class="desc">Approve meeting with tiger</div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left bg-light-primary text-primary">
                                <i data-feather="user" class="feather-sm fill-white"></i>
                            </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Meeting today <span class="sl-date"> 5pm</span></div>
                                <div class="desc">you can write anything </div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left bg-light-info text-info">
                                <i data-feather="send" class="feather-sm fill-white"></i>
                            </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Send documents to Clark</div>
                                <div class="desc">Lorem Ipsum is simply </div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left"> <img class="rounded-circle" alt="user" src="{{asset('assets/images/users/4.jpg')}}"> </div>
                            <div class="sl-right">
                                <div class="font-weight-medium">Go to the Doctor <span class="sl-date">5 minutes
                                        ago</span>
                                </div>
                                <div class="desc">Contrary to popular belief</div>
                            </div>
                        </div>
                        <div class="sl-item">
                            <div class="sl-left"> <img class="rounded-circle" alt="user" src="{{asset('assets/images/users/6.jpg')}}"> </div>
                            <div class="sl-right">
                                <div><a href="javascript:void(0)">Stephen</a> <span class="sl-date">5 minutes
                                        ago</span>
                                </div>
                                <div class="desc">Approve meeting with tiger</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Tab 3 -->
            </div>
        </div>
    </aside>
    <div class="chat-windows"></div>
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{asset('assets/libs/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- apps -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('js/app.init.js')}}"></script>
    <script src="{{asset('js/app-style-switcher.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/sparkline/sparkline.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{asset('js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{asset('js/sidebarmenu.js')}}"></script>
    <!--Custom JavaScript -->
    <script src="{{asset('js/feather.min.js')}}"></script>
    <script src="{{asset('js/custom.min.js')}}"></script>
    <script src="{{asset('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!--This page JavaScript -->
    <!-- chartist chart -->
    <script src="{{asset('assets/libs/moment/min/moment.min.js')}}"></script>
    <script src="{{asset('assets/libs/fullcalendar/dist/fullcalendar.min.js')}}"></script>
    <script src="{{asset('js/pages/calendar/cal-init.js')}}"></script>
    <script src="{{asset('assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
    <!-- Vector map JavaScript -->
    <script src="{{asset('assets/libs/jvectormap/jquery-jvectormap.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/jvector/jquery-jvectormap-world-mill-en.js')}}"></script>
    <!-- Chart JS -->
    <script src="{{asset('assets/extra-libs/input-tel/js/intlTelInput.min.js')}}"></script>
    <script src="{{asset('assets/extra-libs/input-tel/js/intlTelInput-jquery.min.js')}}"></script>
    <script src="{{asset('assets/libs/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{asset('assets/libs/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('assets/libs/quill/dist/quill.min.js')}}"></script>
    <script src="{{asset('assets/libs/block-ui/jquery.blockUI.js')}}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script> 
 
    @include('user.partials.notify')
    @stack('footer-script')


</body>

</html>