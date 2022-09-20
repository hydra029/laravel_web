@section('menu')
    <li class="side-nav-item">
        <a href="{{route('ceo.index')}}" class="side-nav-link" id="home">
            <i class="uil-home-alt"></i>
            <span> Dashboards </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.employee_attendance')}}" class="side-nav-link">
            <i class="uil-calendar-alt"></i>
            <span> Employee Attendance </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.employee_salary')}}" class="side-nav-link">
            <i class="uil-calendar-alt"></i>
            <span> Employee Salary </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="javascript: void(0);" aria-expanded="false" class="side-nav-link">
            <i class="uil uil-bright"></i>
            <span> Configuration </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="side-nav-second-level" aria-expanded="false">
            <li class="side-nav-item">
                <a href="{{route('ceo.fines')}}" class="side-nav-link">
                    <i class="uil-money-bill pl-2"></i>
                    <span class="pl-2"> Fines </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{route('ceo.time')}}" class="side-nav-link">
                    <i class="uil-clock pl-2"></i>
                    <span class="pl-2"> Time </span>
                </a>
            </li>
            <li class="side-nav-item">
                <a href="{{route('ceo.roles')}}" class="side-nav-link">
                    <i class="uil-moneybag-alt pl-2"></i>
                    <span class="pl-2"> Roles </span>
                </a>
            </li>
        </ul>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.create_emp')}}" class="side-nav-link">
            <i class="uil-plus-square"></i>
            <span> Add employee </span>
        </a>
    </li>
@endsection
