@section('menu')

	<li class="side-nav-item">
		<a href="{{route('managers.index')}}" class="side-nav-link">
			<i class="uil-home-alt"></i>
			<span> Dashboards </span>
		</a>
	</li>
	<li class="side-nav-item">
		<a href="{{route('managers.attendance_history')}}" class="side-nav-link">
			<i class="uil-calendar-alt"></i>
			<span> Attendance History </span>
		</a>
	</li>
	{{-- <li class="side-nav-item">
		<a href="{{route('managers.today_attendance')}}" class="side-nav-link">
			<i class="uil-calendar-alt"></i>
			<span> Today Attendance </span>
		</a>
	</li> --}}
	<li class="side-nav-item">
		<a href="{{route('managers.employee_attendance')}}" class="side-nav-link">
			<i class="uil-calendar-alt"></i>
			<span> Employee Attendance </span>
		</a>
	</li>
		<li class="side-nav-item">
			{{-- <a href="{{route('managers.assignment')}}" class="side-nav-link">
				<i class="uil-money-bill"></i>
				<span> Assignment </span>
			</a> --}}
			<a href="{{route('managers.salary')}}" class="side-nav-link">
				<i class="uil-money-bill"></i>
				<span> Salary </span>
			</a>
		</li>
@endsection
