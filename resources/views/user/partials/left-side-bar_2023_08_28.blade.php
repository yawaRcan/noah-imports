<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar mt-md-0 mt-sm-5 mt-1">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- User profile -->
        <div class="user-profile position-relative" style="background: url('{{asset('assets/images/background/user-info.jpg')}}') no-repeat;">
            <!-- User profile image -->
            <div class="profile-img"> <img src="{{asset('assets/images/users/profile.png')}}" alt="user" class="w-100" /> </div>
            <!-- User profile text-->
            <div class="profile-text pt-1 dropdown">
                <a href="#" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">{{Auth::user()->name}}</a>
                <div class="dropdown-menu animated flipInY" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="{{route('account.index')}}"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>Edit Account</a>
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                    <button class="dropdown-item" href="#" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i data-feather="log-out"
                            class="feather-sm text-danger me-1 ms-1"></i> Logout</button>
                     </form>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Dashboard</span>
                </li> 
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.index')}}" aria-expanded="false"><span class="mdi mdi-view-dashboard"></span><span class="hide-menu">Dashboard </span></a> 
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Purchasing
                @if(notificationsCount('Purchases') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Purchases')}}</span>
                @endif</span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.purchasing.order.list')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">View List</span></a></li> 
                        <li class="sidebar-item"><a href="{{route('user.purchasing.order.pendingOrders')}}"class="sidebar-link"><span class="mdi mdi-lan-pending"></span><span class="hide-menu">Pending Orders</span></a></li>
                        <li class="sidebar-item"><a href="{{route('user.purchasing.create')}}"class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Create Order</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-truck-delivery"></span><span class="hide-menu">Parcels 
                @if(notificationsCount('Parcel') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Parcel')}}
                @endif
                </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.parcel.create')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Create Shipment</span></a></li>
                        <li class="sidebar-item"><a href="{{route('user.parcel.index')}}" class="sidebar-link"><span class="mdi mdi-format-list-bulleted-type"></span><span class="hide-menu">View List</span></a></li>
                        <li class="sidebar-item"><a href="{{route('user.parcel.pendingParcels')}}" class="sidebar-link"><span class="mdi mdi-lan-pending"></span><span class="hide-menu">Pending Shipment</span></a></li>
                        <li class="sidebar-item"><a href="{{route('user.parcel.archivedParcels')}}" class="sidebar-link"><span class="mdi mdi-archive"></span><span class="hide-menu">Archived Shipments</span></a></li>
                        
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.consolidate.index')}}"><span class="mdi mdi-console"></span><span class="hide-menu">Consolidate 
                @if(notificationsCount('Consolidate') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Consolidate')}}</span>
                @endif
                </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.parcel.draftedParcels')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Past Orders </span></a> </li> 
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Ecommerce </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.online-store.index')}}" class="sidebar-link"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Online Store</span></a></li> 
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Orders </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{route('user.ec-order.list')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">All Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('user.ec-order.list', ['status' => 'pending'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Pending Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('user.ec-order.list', ['status' => 'delivered'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Delivered Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('user.ec-order.list', ['status' => 'cancelled'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Cancelled Orders</span></a></li>
                            </ul>
                        </li>
                       
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-account-settings-variant"></span><span class="hide-menu">Account 
                @if(notificationsCount('Account') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Account')}}</span>
                @endif 
                </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.shipping-address.index')}}" class="sidebar-link"><span class="mdi mdi-home"></span><span class="hide-menu">Shipper Address</span></a></li> 
                        <li class="sidebar-item"><a href="{{route('user.account.index')}}" class="sidebar-link"><span class="mdi mdi-account-box"></span><span class="hide-menu">Edit Account</span></a></li>
                        <li class="sidebar-item"><a href="{{route('user.account.profile.view')}}" class="sidebar-link"><span class="mdi mdi-security"></span><span class="hide-menu">Profile & Privacy</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.calendar.index')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Calendars </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.wallet.index')}}"><span class="mdi mdi-console"></span><span class="hide-menu">Wallet
                @if(notificationsCount('Wallet') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Wallet')}}</span>
                @endif
                </span></a> </li> 
                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Others</span>
                </li> 
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-settings"></span><span class="hide-menu">Settings </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.shipping.calculator.index')}}" class="sidebar-link"><span class="mdi mdi-calculator"></span><span class="hide-menu">Shipping Calculator</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link" href="{{route('user.carCalculator.index')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Car Calculator </span></a> </li>
                        <li class="sidebar-item"><a href="{{route('user.rate.index')}}" class="sidebar-link"><span class="mdi mdi-vibrate"></span><span class="hide-menu">Rates</span></a></li>
                    </ul>
                </li> 
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
    <!-- Bottom points-->
    <!-- <div class="sidebar-footer">
        
        <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Settings"><i class="ti-settings"></i></a>
        
        <a href="" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Email"><i class="mdi mdi-gmail"></i></a>
          
        <form method="POST" action="{{ route('logout') }}">
            @csrf
        <a href="#" class="link" data-bs-toggle="tooltip" data-bs-placement="top" title="Logout" onclick="event.preventDefault();
                                                this.closest('form').submit();"><i class="mdi mdi-power"></i></a>
        </form>
    </div> -->
    <!-- End Bottom points-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->