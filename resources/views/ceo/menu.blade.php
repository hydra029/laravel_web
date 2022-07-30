@section('menu')
    <li class="side-nav-item">
        <a href="{{route('ceo.index')}}" class="side-nav-link" id="home">
            <i class="uil-home-alt"></i>
            <span> Dashboards </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.time')}}" class="side-nav-link">
            <i class="uil-clock"></i>
            <span> Time </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.employee_attendance')}}" class="side-nav-link">
            <i class="uil-calendar-alt"></i>
            <span> Employee Attendance </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.fines')}}" class="side-nav-link">
            <i class="uil-money-bill"></i>
            <span> Fines </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.department')}}" class="side-nav-link">
            <i class="uil-briefcase-alt"></i>
            <span> Department </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.create_emp')}}" class="side-nav-link">
            <i class="uil-plus-square"></i>
            <span> Add employee </span>
        </a>
    </li>
@endsection
