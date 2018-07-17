<div id="admin-top-bar">
<div class="admin-bar">
    <div class="admin-bar__main-menu">
    <button class="btn"><span class="lines-menu"></span></button>
    </div>
    <div class="admin-bar__context">
    <div class="inner">
        <h1 class="admin-bar__context-title">Add Prezent User</h1>
    </div>
    </div>
    <div class="admin-bar__nav">
    <span class="mobile-nav-toggle"><i class="fa fa-bars"></i></span>
    <ul>
        <li class="nav__support">
        <a href="#"><span class="icon-ic_support"></span></a>
        </li>
        <li class="nav__notification parent-menu incoming-notification has-notification">
        <a href="#">
            <span class="icon-ic_notif"></span>
            <span class="notification-counter">121</span>
        </a>
        <ul class="sub-menu notification__dropdown">
            <li class="notif__head">
            New Notification <span class="new-notif-count">2</span>
            </li>
            <li class="notif__status-pending unread">
            <a href="#">
                <div class="notif__inner">
                <span class="notif__campaign-name"><strong>Pending Invoice :</strong> Invoice No. D-0011</span>
                &ndash; <span class="notif__campaign-date">29 Aug 2018</span>
                <p class="notif__campaign-created">Today &ndash; 8.15 <span></span></p>
                </div>
            </a>
            </li>
            <li class="notif__status-paid unread">
            <a href="#">
                <div class="notif__inner">
                <span class="notif__campaign-name"><strong>Invoice Paid :</strong> Invoice No. D-0006</span>
                <p class="notif__campaign-created">Today &ndash; 8.02 <span></span></p>
                </div>
            </a>
            </li>
            <li class="notif__status-new">
            <a href="#" class="sign-out">
                <div class="notif__inner">
                <span class="notif__campaign-name"><strong>PT. Mitra Adhi Perkasa</strong> want to start a campaign.</span>
                <p class="notif__campaign-created">Yesterday &ndash; 9.12 <span></span></p>
                </div>
            </a>
            </li>
            <li class="notif__status-paid">
            <a href="#">
                <div class="notif__inner">
                <span class="notif__campaign-name"><strong>Invoice Paid :</strong> Invoice No. D-0002</span>
                <p class="notif__campaign-created">8 May 2018 &ndash; 10.30 <span></span></p>
                </div>
            </a>
            </li>
            <li class="notif__footer">
            <a href="#">Show more notifications</a>
            </li>
        </ul>
        </li>
        <li class="user-menu parent-menu">
        <a href="#">
            <span class="user-menu__avatar"></span>
            <span class="user-menu__name">Annisa Kinanti</span>
            <span class="profile-menu-toggle"><i class="fa fa-angle-down"></i></span>
        </a>
        <ul class="sub-menu">
            <li><a href="#">Edit Profile</a></li>
            <li><a href="#">Change Password</a></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
            </li>
        </ul>
        </li>
    </ul>
    </div>
    <div class="admin-bar__shortcut">
    <div class="btn-zoom-in-shadow">
        <button class="btn shortcut border-0 plus" data-toggle="modal" data-target="#userMenuModal"><i class="fa fa-plus"></i></button>
    </div>
    </div>
</div>
</div>