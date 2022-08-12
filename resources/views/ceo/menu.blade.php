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
        <a href="{{route('ceo.department')}}" class="side-nav-link">
            <i class="uil-briefcase-alt"></i>
            <span> Department </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.salary')}}" class="side-nav-link">
            <i class="uil-calendar-alt"></i>
            <span> Salary </span>
        </a>
    </li>
    <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="side-nav-link" id="home">
        <i class="uil uil-bright" ></i>
        <span> Configuration </span>
        <i class="uil uil-angle-down" ></i>
    </a>
    <div class="collapse ml-2" id="collapseExample">
        <li class="side-nav-item" >
            <a href="{{route('ceo.fines')}}" class="side-nav-link">
                <i class="uil-money-bill"></i>
                <span> Fines </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('ceo.time')}}" class="side-nav-link">
                <i class="uil-clock"></i>
                <span> Time </span>
            </a>
        </li>
        <li class="side-nav-item" >
            <a href="{{route('ceo.roles')}}" class="side-nav-link">
                <i class="uil uil-moneybag-alt"></i>
                <span> Roles </span>
            </a>
        </li>
    </div>
    <li class="side-nav-item">
        <a href="{{route('ceo.create_emp')}}" class="side-nav-link">
            <i class="uil-plus-square"></i>
            <span> Add employee </span>
        </a>
    </li>
@endsection
