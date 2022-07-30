@section('menu')
    <li class="side-nav-item">
        <a href="{{route('employees.index')}}" class="side-nav-link" id="home">
            <i class="uil-home-alt"></i>
            <span> Dashboards </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('employees.attendance_history')}}" class="side-nav-link">
            <i class="uil-calendar-alt"></i>
            <span> Attendance History </span>
        </a>
    </li>
@endsection
