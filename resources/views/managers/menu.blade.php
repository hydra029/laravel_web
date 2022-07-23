@section('menu')
    <li class="side-nav-item">
        <a href="{{route('managers.attendance')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Attendance History </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('managers.today_attendance')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Today Attendance </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('managers.employee_attendance')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Employee Attendance </span>
        </a>
    </li>
@endsection
