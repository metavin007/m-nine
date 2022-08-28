<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <!--<a href="{{ route('profile') }}"><img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" srcset=""></a>-->
                    <h1><center style="font-size: 24px;"><b>M-NINE (THAILAND)</b></center></h1>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Menu</li>
                <li
                    class="sidebar-item {{ request()->is('profile*') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}" class='sidebar-link'>
                        <i class="bi bi-person-circle"></i>
                        <span>Pofile</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('notification_invoice*') ? 'active' : '' }}">
                    <a href="{{ route('notification_invoice') }}" class='sidebar-link'>
                        <i class="bi bi-alarm"></i>
                        <span>Notification invoice</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('costs*') ? 'active' : '' }}">
                    <a href="{{ route('costs') }}" class='sidebar-link'>
                        <i class="bi bi-calculator"></i>
                        <span>Costs</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('report_standard*') ? 'active' : '' }}">
                    <a href="{{ route('report_standard') }}" class='sidebar-link'>
                        <i class="bi bi-briefcase"></i>
                        <span>Report Standard</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('header_pdf*') ? 'active' : '' }}">
                    <a href="{{ route('header_pdf') }}" class='sidebar-link'>
                        <i class="bi bi-gear-fill"></i>
                        <span>Header PDF</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('shipper*') ? 'active' : '' }}">
                    <a href="{{ route('shipper') }}" class='sidebar-link'>
                        <i class="bi bi-building"></i>
                        <span>Shipper</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('item*') ? 'active' : '' }}">
                    <a href="{{ route('item') }}" class='sidebar-link'>
                        <i class="bi bi-cart-plus"></i>
                        <span>Item</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('customer*') ? 'active' : '' }}">
                    <a href="{{ route('customer') }}" class='sidebar-link'>
                        <i class="bi bi-person-square"></i>
                        <span>Customer</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('invoice*') ? 'active' : '' }}">
                    <a href="{{ route('invoice') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Invoice</span>
                    </a>
                </li>
                <li
                    class="sidebar-item {{ request()->is('receipt*') ? 'active' : '' }}">
                    <a href="{{ route('receipt') }}" class='sidebar-link'>
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Receipt</span>
                    </a>
                </li>
                <li class="sidebar-item ">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="#" class='sidebar-link' onclick="event.preventDefault();
                                this.closest('form').submit();">
                            <i class="bi bi-door-open"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </li>
                <li
                    class="sidebar-item ">
                    @if(\Auth::user()->color_mode == 1)
                    <form method="POST" action="{{ route('change_to_dark_mode') }}">
                        @csrf
                        <button type="button" class="btn btn-edit btn-dark" style="width: -webkit-fill-available;"
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"><i class="bi bi-moon"></i> Dark mode</button>
                    </form>
                    @elseif(\Auth::user()->color_mode == 2)
                    <form method="POST" action="{{ route('change_to_white_mode') }}">
                        @csrf
                        <button type="button" class="btn btn-edit btn-light" style="width: -webkit-fill-available;" 
                                onclick="event.preventDefault();
                                        this.closest('form').submit();"><i class="bi bi-sun"></i> White mode</button>
                    </form>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>