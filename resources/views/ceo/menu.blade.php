@section('menu')
    <li class="side-nav-item">
        <a href="{{route('ceo.time')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Time </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.pay_rate')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Pay rate </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{route('ceo.department')}}" class="side-nav-link">
            <i class="uil-home-alt"></i>
            <span> Department </span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="#" class="side-nav-link">
            <i class="uil-calender"></i>
            <span> Calendar </span>
        </a>
    </li>

    <li class="side-nav-item">
        <a href="#" class="side-nav-link">
            <i class="uil-comments-alt"></i>
            <span> Chat </span>
        </a>
    </li>
@endsection