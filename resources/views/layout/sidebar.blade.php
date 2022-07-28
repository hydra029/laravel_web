<div class="left-side-menu">

    <div class="leftbar-user">
        <a href="javascript: void(0);">
            <img src="{{ asset('img/Dynastylogo_square.webp') }}" alt="user-image" height="42"
                 class="rounded-circle shadow-sm">
            <span class="leftbar-user-name m-0">
                {{session('name')}}
            </span>
        </a>
        <span class="m-0">
                {{session('dept_name')}} - {{session('role_name')}}
            </span>
    </div>
    <ul class="metismenu side-nav">
        <li class="side-nav-title side-nav-item">Navigation</li>

        @yield('menu')
    </ul>
    <!-- Help Box -->

    <!-- end Help Box -->
    <div class="clearfix"></div>
    <!-- Sidebar -left -->

</div>
