@extends('layout.master')
@include('managers.menu')
@push('css')
	<style>
        .not-allow :hover {
            cursor: not-allowed;
        }

        .acct {
            width: 30%;
        }

        td, th {
            vertical-align: middle !important;
            height: 70px;
        }
	</style>
@endpush
@section('content')
	<table class="table table-bordered table-striped">
		<tr>
			<th class="text-center">
				Department
			</th>
			<th class="text-center">
				Accountant
			</th>
			<th class="text-center">
				Action
			</th>
		</tr>
		@foreach($data as $each)
			<tr>
				<form>
					@csrf
					<input type="hidden" name="id" value="{{ $each->id }}"/>
					<td class="col-5 text-center">
						{{ $each->name }}
					</td>
					<td class="col-5 text-center">
						<div class="btn-group acct d-none dropdown">
							<button class="btn btn-success dropdown-toggle default-acct" type="button"
							        data-toggle="dropdown"
							        aria-haspopup="true" aria-expanded="false">
								{{ $each->id === 1 ? session('name') : $each->acct }}
							</button>
							<div class="dropdown-menu dropdown-menu-animated">
							</div>
						</div>
						<div class="acc">
							{{ $each->id === 1 ? session('name') : $each->acct }}
						</div>
					</td>
					@if ($each->id === 1)
						<td class="col-2 text-center not-allow">
							<i class="fa-solid fa-pen text-warning"></i>
							<i class="fa-solid fa-square-xmark text-danger"></i>
						</td>
					@else
						<td class="col-2 text-center">
							<i class="fa-solid fa-pen btn-edit-role text-warning" data-id="{{ $each->id }}"
							   data-acct_id="{{ $each->acct_id }}"></i>
							<i class="fa-solid fa-check btn-check-role text-success d-none"
							   data-id="{{ $each->id }}"></i>
							<i class="fa-solid fa-square-xmark btn-delete-role text-danger"
							   data-id="{{ $each->id }}"></i>
						</td>
					@endif
				</form>
			</tr>
		@endforeach
	</table>
@endsection
@push('js')
	<script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let edit = $('.btn-edit-role');
            let del  = $('.btn-delete-role');
            edit.click(function () {
                $(this).addClass('d-none');
                let tr      = $(this).parents('tr');
                let acct_id = $(this).data('acct_id');
                tr.find('.acc').addClass('d-none');
                tr.find('.acct').removeClass('d-none');
                tr.find('.fa-check').removeClass('d-none');
                let dd = tr.find('.dropdown-menu');
                $.ajax({
                    type    : 'GET',
                    dataType: 'json',
                    url     : '{{route('managers.accountant_api')}}',
                })
                    .done(function (response) {
                        for (let i = 0; i < response.length; i++) {
                            let id   = response[i]['id'];
                            let name = response[i]['fname'] + ' ' + response[i]['lname'];
                            if (id === acct_id) {
                                dd.append($('<a>')
                                    .attr({
                                        href          : '#',
                                        "data-acct_id": id,
                                    })
                                    .addClass('dropdown-item active')
                                    .text(name)
                                )
                            } else {
                                dd.append($('<a>')
                                    .attr({
                                        href          : '#',
                                        "data-acct_id": id
                                    })
                                    .addClass('dropdown-item')
                                    .text(name)
                                )
                            }
                        }
                        $('.dropdown-item').click(function () {
                            tr.find('.dropdown-item').removeClass('active');
                            $(this).addClass('active');
                            tr.find('.default-acct').text($(this).text());
                            tr.find('.acc').text($(this).text());
                        })
                    })
            })
            $('.fa-check').click(function () {
                let tr      = $(this).parents('tr');
                let acct_id = tr.find('.active').data('acct_id');
                let dept_id = $(this).data('id');
                tr.find('.acc').removeClass('d-none');
                tr.find('.acct').addClass('d-none');
                tr.find('.fa-check').addClass('d-none');
                tr.find('.fa-pen').removeClass('d-none');
                let dd = tr.find('.dropdown-menu');
                $.ajax({
                    type    : 'POST',
                    dataType: 'json',
                    url     : '{{route("managers.assign_accountant")}}',
                    data    : {
                        dept_id: dept_id,
                        acct_id: acct_id,
                    }
                })
                    .done(function (response) {
                        dd.empty();
                        if (response === 0) {
                            $.toast({
                                heading  : 'Successful Execution',
                                text     : 'You\'ve assigned an accountant successfully',
                                icon     : 'success',
                                position : 'top-right',
                                hideAfter: 2000,
                            });
                        }
                        if (response === 1) {
                            $.toast({
                                heading  : 'Failed Execution',
                                text     : 'Do not try to break our system !',
                                icon     : 'error',
                                position : 'top-right',
                                hideAfter: 2000,
                            });
                        }
                    })
            })
	        del.click(function() {
                let tr      = $(this).parents('tr');
                let dept_id = $(this).data('id');
                $.ajax({
	              type: 'POST',
	              datatype: 'json',
	              url: '{{ route("managers.assign_accountant")}}',
	              data: { dept_id: dept_id, acct_id: 0 },
                })
	                .done(function() {
                        tr.find('.acc').text('unassigned');
                        tr.find('.default-acct').text('unassigned');
                        tr.find('.fa-check').removeData('acct_id');
	                })
	        })
        })
	</script>
@endpush
