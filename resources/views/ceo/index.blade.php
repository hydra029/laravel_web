@extends('layout.master')
@include('ceo.menu')
@section('content')

	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<table class="table table-striped table-centered table-bordered mb-20" id="student-table-index">
		<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Gender</th>
			<th>Age</th>
			<th>Email</th>
			<th>Department</th>
			<th>Role</th>
		</tr>
		</thead>
		@foreach($acc as $each)
			<tr>
				<td>
					{{$num++}}
				</td>
				<td>
					{{$each -> full_name}}
				</td>
				<td>
					{{$each -> gender_name}}
				</td>
				<td>
					{{$each -> age}}
				</td>
				<td>
					{{$each -> email}}
				</td>
				<td>
					{{$each -> departments -> name}}
				</td>
				<td>
					{{$each -> roles -> name}}
				</td>
			</tr>
		@endforeach
		@foreach($data as $each)
			<tr>
				<td>
					{{$num++}}
				</td>
				<td>
					{{$each -> full_name}}
				</td>
				<td>
					{{$each -> gender_name}}
				</td>
				<td>
					{{$each -> age}}
				</td>
				<td>
					{{$each -> email}}
				</td>
				<td>
					{{$each -> departments -> name}}
				</td>
				<td>
					{{$each -> roles -> name}}
				</td>
			</tr>
		@endforeach
	</table>
	<nav>
		<ul class="pagination pagination-rounded mb-0">
			<li class="page-item">
				{{ $data->links() }}
			</li>
		</ul>
	</nav>
@endsection
@push('js')
@endpush
