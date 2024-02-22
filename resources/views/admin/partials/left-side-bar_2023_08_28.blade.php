<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar">
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
                    <a class="dropdown-item" href="#"><i data-feather="user" class="feather-sm text-info me-1 ms-1"></i>Edit Account</a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="dropdown-item" href="#" onclick="event.preventDefault();
                        this.closest('form').submit();"><i data-feather="log-out" class="feather-sm text-danger me-1 ms-1"></i> Logout</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- End User profile text-->
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span class="hide-menu">Dashboard</span>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('admin.index')}}" aria-expanded="false"><span class="mdi mdi-view-dashboard"></span><span class="hide-menu">Dashboard </span></a>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-truck-delivery"></span><span class="hide-menu">Parcels 
                 @if(notificationsCount('Parcel') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Parcel')}}
                @endif
                </span></span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('parcel.create')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Create Shipment</span></a></li>
                        <li class="sidebar-item"><a href="{{route('parcel.index')}}" class="sidebar-link"><span class="mdi mdi-format-list-bulleted-type"></span><span class="hide-menu">View List</span></a></li>
                        <li class="sidebar-item"><a href="{{route('parcel.pendingParcels')}}" class="sidebar-link"><span class="mdi mdi-lan-pending"></span><span class="hide-menu">Pending Shipments</span></a></li>
                        <li class="sidebar-item"><a href="{{route('parcel.archivedParcels')}}" class="sidebar-link"><span class="mdi mdi-archive"></span><span class="hide-menu">Archived Shipments</span></a></li>
                        
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('consolidate.index')}}"><span class="mdi mdi-console"></span><span class="hide-menu">Consolidate
                @if(notificationsCount('Consolidate') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Consolidate')}}</span>
                @endif </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Purchasing
                @if(notificationsCount('Purchases') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Purchases')}}</span>
                @endif </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('purchase.category.index')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">Category</span></a></li>
                        <li class="sidebar-item"><a href="{{route('purchasing.order.list')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">View List</span></a></li>
                        <li class="sidebar-item"><a href="{{route('purchasing.create')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Create Order</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Ecommerce </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('online-store.index')}}" class="sidebar-link"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Online Store</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Products </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{route('product.create')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Add Product</span></a></li> 
                                <li class="sidebar-item"><a href="{{route('product.index')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">View Products</span></a></li> 
                            </ul>
                        </li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Categories</span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{route('category.index')}}" class="sidebar-link"><span class="mdi  mdi-plus"></span><span class="hide-menu">Category</span></a></li>
                                <li class="sidebar-item"><a href="{{route('subcategory.index')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Sub Category</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="{{route('brand.index')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">Brands</span></a></li>
                        <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-cart-plus"></span><span class="hide-menu">Orders </span></a>
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{route('ec-order.list')}}" class="sidebar-link"><span class="mdi mdi-playlist-minus"></span><span class="hide-menu">All Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('ec-order.list', ['status' => 'pending'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Pending Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('ec-order.list', ['status' => 'delivered'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Delivered Orders</span></a></li>
                                <li class="sidebar-item"><a href="{{route('ec-order.list', ['status' => 'cancelled'])}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Cancelled Orders</span></a></li>
                            </ul>
                        </li>
                        <li class="sidebar-item"><a href="{{route('coupon.index')}}" class="sidebar-link"><span class="mdi mdi-plus"></span><span class="hide-menu">Coupon Code</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-account-multiple-plus"></span><span class="hide-menu">User List 
                @if(notificationsCount('User') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('User')}}</span>
                @endif
                </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('user.val.index')}}" class="sidebar-link"><span class="mdi mdi-account-network"></span><span class="hide-menu">User List</span></a></li>
                        <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="mdi mdi-account-multiple"></span><span class="hide-menu">Staff List</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-account-settings-variant"></span><span class="hide-menu">Account
                @if(notificationsCount('Account') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Account')}}</span>
                @endif </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('shipping-address.index')}}" class="sidebar-link"><span class="mdi mdi-home"></span><span class="hide-menu">Shipper Address</span></a></li>
                        <li class="sidebar-item"><a href="{{route('pickup-station.index')}}" class="sidebar-link"><span class="mdi mdi-map-marker-circle"></span><span class="hide-menu"></span>Pickup Station</a></li>
                        <li class="sidebar-item"><a href="{{route('account.index')}}" class="sidebar-link"><span class="mdi mdi-account-box"></span><span class="hide-menu">Edit Account</span></a></li>
                        <li class="sidebar-item"><a href="{{route('account.profile.view')}}" class="sidebar-link"><span class="mdi mdi-security"></span><span class="hide-menu">Profile & Privacy</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('parcel.draftedParcels')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Draft </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('announcement.create')}}"><span class="mdi mdi-reply-all"></span><span class="hide-menu">Announcement </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-console"></span><span class="hide-menu">Wallet 
                @if(notificationsCount('Wallet') > 0)    
                <span class="badge ms-auto bg-info">{{notificationsCount('Wallet')}}</span>
                @endif
                </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('wallet.index')}}" class="sidebar-link"><span class="mdi mdi-account-network"></span><span class="hide-menu">User Wallets</span></a></li>
                        <!-- <li class="sidebar-item"><a href="javascript:void(0)" class="sidebar-link"><span class="mdi mdi-account-multiple"></span><span class="hide-menu">Staff List</span></a></li> -->
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('reports.list')}}"><span class="mdi mdi-clipboard-text"></span><span class="hide-menu">Generate Report </span></a> </li> 
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('calendar.index')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Calendars </span></a> </li>
                <li class="sidebar-item"> <a class="sidebar-link" href="{{route('carCalculator.index')}}"><span class="mdi mdi-pencil-off"></span><span class="hide-menu">Car Calculator </span></a> </li>
                <li class="sidebar-item"><a href="{{route('shippingCalulator.index')}}" class="sidebar-link"><span class="mdi mdi-calculator"></span><span class="hide-menu">Shipping Calculator</span></a></li>

                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-console"></span><span class="hide-menu">Languages
                </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{ route('languages.index') }}" class="sidebar-link"><span class="mdi mdi-account-network"></span><span class="hide-menu">All Languages</span></a></li>
                    </ul>
                </li>
                <!-- <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-console"></span><span class="hide-menu">Calendars </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                    <li class="sidebar-item"> <a class="sidebar-link" href="{{route('calendar.parcel')}}"><span class="mdi mdi-clipboard-text"></span><span class="hide-menu">Parcels Calendar </span></a> </li>
                    <li class="sidebar-item"> <a class="sidebar-link" href="{{route('calendar.consolidate')}}"><span class="mdi mdi-clipboard-text"></span><span class="hide-menu">Consolidates Calendar </span></a> </li>
                    <li class="sidebar-item"> <a class="sidebar-link" href="{{route('calendar.order')}}"><span class="mdi mdi-clipboard-text"></span><span class="hide-menu">Orders Calendar </span></a> </li>
                    </ul>
                </li> -->

                <li class="nav-small-cap">
                    <i class="mdi mdi-dots-horizontal"></i>
                    <span class="hide-menu">Others</span>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-settings"></span><span class="hide-menu">Settings </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('settings.configurations')}}" class="sidebar-link"><span class="mdi mdi-tune"></span><span class="hide-menu">Configuration</span></a></li>
                        <li class="sidebar-item"><a href="{{route('settings.index')}}" class="sidebar-link"><span class="mdi mdi-settings-box"></span><span class="hide-menu">Settings</span></a></li>
                        <li class="sidebar-item"><a href="{{route('email.templates.index')}}" class="sidebar-link"><span class="mdi mdi-settings-box"></span><span class="hide-menu">Email Templates</span></a></li>
                    </ul>
                </li>
                <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><span class="mdi mdi-more"></span><span class="hide-menu">More </span></a>
                    <ul aria-expanded="false" class="collapse  first-level">
                        <li class="sidebar-item"><a href="{{route('branch.index')}}" class="sidebar-link"><span class="mdi mdi-format-align-left"></span><span class="hide-menu">Branch</span></a></li>
                        <li class="sidebar-item"><a href="layout-inner-fixed-right-sidebar.html" class="sidebar-link"><span class="mdi mdi-google-translate"></span><span class="hide-menu"> Language </span></a></li>
                        <li class="sidebar-item"><a href="{{route('shipment-mode.index')}}" class="sidebar-link"><span class="mdi mdi-format-float-left"></span><span class="hide-menu"> Shipment Mode
                                </span></a></li>
                        <li class="sidebar-item"><a href="{{route('shipment-type.index')}}" class="sidebar-link"><span class="mdi mdi-format-float-right"></span><span class="hide-menu"> Shipment Type
                                </span></a></li>
                        <li class="sidebar-item"><a href="{{route('config-status.index')}}" class="sidebar-link"><span class="mdi mdi-view-quilt"></span><span class="hide-menu"> Parcel Status
                                </span></a></li>
                        <li class="sidebar-item"><a href="{{route('external-shipper.index')}}" class="sidebar-link"><span class="mdi mdi-view-parallel"></span><span class="hide-menu"> External Courier
                                </span></a></li>
                        <li class="sidebar-item"><a href="{{route('payment.index')}}" class="sidebar-link"><span class="mdi mdi-cash-multiple"></span><span class="hide-menu">
                                    Payments </span></a></li>
                        <li class="sidebar-item"><a href="{{route('currency.index')}}" class="sidebar-link"><span class="mdi mdi-currency-usd"></span><span class="hide-menu"> Currency </span></a></li>
                        <li class="sidebar-item"><a href="{{route('import-duty.index')}}" class="sidebar-link"><span class="mdi mdi-import"></span><span class="hide-menu"> Import Duty </span></a></li>
                        <li class="sidebar-item"><a href="{{route('rate.index')}}" class="sidebar-link"><span class="mdi mdi-vibrate"></span><span class="hide-menu"> Rates </span></a></li>
                        <li class="sidebar-item"><a href="{{route('discount.index')}}" class="sidebar-link"><span class="mdi mdi-discord"></span><span class="hide-menu"> Discount </span></a></li>
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
        
        <form method="POST" action="{{ route('admin.logout') }}">
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