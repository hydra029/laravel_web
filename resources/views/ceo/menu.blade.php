@section('menu')
    
    <li class="side-nav-item">
        <a href="{{route('ceo.index')}}" class="side-nav-link" id="home">
            <i class="fa-solid fa-calendar-days"></i>
            <span> Dashboards </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.attendance')}}" class="side-nav-link">
            <i class="fa-solid fa-clipboard-user"></i>
            <span> Attendance </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.department')}}" class="side-nav-link">
            <i class="fa-solid fa-building-user"></i>
            <span> Department </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="side-nav-link" id="home">
            <i class="fa-solid fa-clipboard-check"></i>
            <span> Configuration </span>
            <i class="fa-solid fa-angle-down float-right" ></i>
        </a>
    </li>
    <div class="collapse" id="collapseExample">
        <li class="side-nav-item">
            <a href="{{route('ceo.fines')}}" class="side-nav-link">
                <i class="fa-solid fa-bug"></i>
                <span> Fines </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('ceo.time')}}" class="side-nav-link">
                <i class="fa-solid fa-business-time"></i>
                <span> Time </span>
            </a>
        </li>
        <li class="side-nav-item">
            <a href="{{route('ceo.roles')}}" class="side-nav-link">
                <i class="fa-solid fa-suitcase-rolling"></i>
                <span> Roles </span>
            </a>
        </li>
    </div>
    <li class="side-nav-item">
        <a href="{{route('ceo.create_emp')}}" class="side-nav-link">
            <i class="fa-solid fa-address-book"></i>
            <span> Add employee </span>
        </a>
    </li>
@endsection
