<div class="left-side-menu">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('img/Dynastylogo_square.webp') }}" alt="user-image" height="42"
                 class="rounded-circle shadow-sm">
            <span class="leftbar-user-name">Hydra</span>
        </a>
    </div>
    <ul class="metismenu side-nav">

        <li class="side-nav-title side-nav-item">Navigation</li>

        <li class="side-nav-item">
            <a href="{{route('login')}}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span> Dashboards </span>
            </a>
        </li>
        @yield('menu')
    </ul>
    <!-- Help Box -->

    <!-- end Help Box -->
    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>