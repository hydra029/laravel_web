@section('menu')
	<li class="side-nav-item">
		<a href="{{route('accountants.index')}}" class="side-nav-link" id="home">
			<i class="uil-home-alt"></i>
			<span> Dashboards </span>
		</a>
	</li>
	<li class="side-nav-item">
		<a href="{{route('accountants.attendance_history')}}" class="side-nav-link">
			<i class="uil-calendar-alt"></i>
			<span> Attendance History </span>
		</a>
	</li>
	<li class="side-nav-item">
		<a href="{{route('accountants.salary')}}" class="side-nav-link">
			<i class="uil-money-bill"></i>
			<span> Salary </span>
		</a>
	</li>
	<li class="side-nav-item">
		<a href="{{route('accountants.employee_salary')}}" class="side-nav-link">
			<i class="uil-money-bill"></i>
			<span> Employee Salary </span>
		</a>
	</li>
@endsection
