@extends('layout.master')
@include('employees.menu')
@section('content')
	<style>
        button {
            width: 90px;
        }

        button:disabled {
            cursor: not-allowed !important;
        }

        table {
            text-align: center;
        }
	</style>
	<table class="table table-bordered table-striped table-centered mb-0" id="table-index">
		<thead>
		<tr>
			<th rowspan="2">Shift</th>
			<th colspan="4">Check In</th>
			<th colspan="4">Check Out</th>
		</tr>
		<tr>
			<th>Start</th>
			<th>End</th>
			<th>Late 1</th>
			<th>Late 2</th>
			<th>Early 1</th>
			<th>Early 2</th>
			<th>Start</th>
			<th>End</th>
		</tr>
		</thead>
		@foreach($data as $each)
			<tr>
				<td>
					<p>{{$each->shift_name}}</p>
				</td>
				<td>
					<p>{{$each->in_start}}</p>
				</td>
				<td>
					<p>{{$each->in_end}}</p>
				</td>
				<td>
					<p>{{$each->in_late_1}}</p>
				</td>
				<td>
					<p>{{$each->in_late_2}}</p>
				</td>
				<td>
					<p>{{$each->out_early_1}}</p>
				</td>
				<td>
					<p>{{$each->out_early_2}}</p>
				</td>
				<td>
					<p>{{$each->out_start}}</p>
				</td>
				<td>
					<p>{{$each->out_end}}</p>
				</td>
			</tr>
		@endforeach
		<tr>
			<th>
				Attendance
			</th>
			<td colspan="4">
				<form id="form-check-in" method="post">
					@csrf
					<input type="hidden" name="attendance">
					<button type="button" class="btn btn-primary btn-block check_in" disabled="disabled">
						Check
					</button>
				</form>
			</td>
			<td colspan="4">
				<form id="form-check-out" method="post">
					@csrf
					<input type="hidden" name="attendance">
					<button type="button" class="btn btn-primary btn-block check_out" disabled="disabled">
						Check
					</button>
				</form>
			</td>
		</tr>
	</table>
@endsection
@push('js')
	<script>
        $(function () {
            let check_in  = $('.check_in');
            let check_out = $('.check_out');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let in_start_1  = $('table tr:nth-child(1) td:nth-child(2)').text().replace(/[^\d:]*/, '');
            let in_start_2  = $('table tr:nth-child(2) td:nth-child(2)').text().replace(/[^\d:]*/, '');
            let in_start_3  = $('table tr:nth-child(3) td:nth-child(2)').text().replace(/[^\d:]*/, '');
            let in_end_1    = $('table tr:nth-child(1) td:nth-child(5)').text().replace(/[^\d:]*/, '');
            let in_end_2    = $('table tr:nth-child(2) td:nth-child(5)').text().replace(/[^\d:]*/, '');
            let in_end_3    = $('table tr:nth-child(3) td:nth-child(5)').text().replace(/[^\d:]*/, '');
            let out_start_1 = $('table tr:nth-child(1) td:nth-child(6)').text().replace(/[^\d:]*/, '');
            let out_start_2 = $('table tr:nth-child(2) td:nth-child(6)').text().replace(/[^\d:]*/, '');
            let out_start_3 = $('table tr:nth-child(3) td:nth-child(6)').text().replace(/[^\d:]*/, '');
            let out_end_1   = $('table tr:nth-child(1) td:nth-child(9)').text().replace(/[^\d:]*/, '');
            let out_end_2   = $('table tr:nth-child(2) td:nth-child(9)').text().replace(/[^\d:]*/, '');
            let out_end_3   = $('table tr:nth-child(3) td:nth-child(9)').text().replace(/[^\d:]*/, '');
            let time        = moment().format('HH:mm');
            if (time <= in_end_1 && time >= in_start_1 || time <= in_end_2 && time >= in_start_2 || time <= in_end_3 && time >= in_start_3) {
                check_in.removeAttr('disabled');
            }
            if (time <= out_end_1 && time >= out_start_1 || time <= out_end_2 && time >= out_start_2 || time <= out_end_3 && time >= out_start_3) {
                check_out.removeAttr('disabled');
            }
            let date = moment().format('YYYY-MM-DD');
            $.ajax({
                url     : "{{ route('employees.history_api') }}",
                type    : 'POST',
                dataType: 'JSON',
                data    : {
                    f: date,
                    l: date
                },
            })
                .done(function (response) {
                    let time        = moment().format('HH:mm');
                    let len         = response[1].length;
                    let in_shift, out_shift    = 0;
                    let shift    = 0;
                    let checkin  = '';
                    let checkout = '';
                    if (time >= in_start_1 && time <= in_end_1) {
                        in_shift = 1;
                    }
                    if (time >= in_start_2 && time <= in_end_2) {
                        in_shift = 2;
                    }
                    if (time >= in_start_3 && time <= in_end_3) {
                        in_shift = 3;
                    }
                    if (time >= out_start_1 && time <= out_end_1) {
                        out_shift = 1;
                    }
                    if (time >= out_start_2 && time <= out_end_2) {
                        out_shift = 2;
                    }
                    if (time >= out_start_3 && time <= out_end_3) {
                        out_shift = 3;
                    }

                    for (let i = 0; i < len; i++) {
                        let shift = response[1][i]['shift'];
                        if (shift === in_shift) {
                            checkin  = response[1][i]['check_in'];
                        }
                        if (shift === out_shift) {
                            checkout = response[1][i]['check_out'];
                            console.log(check_out);
                        }
                    }
                    if(checkin === 0 || checkin === null) {
                        check_in.prop(disabled, true);
                    }
                    if(checkout === 0 || checkout === null) {
                        check_out.prop(disabled, true);
                    }
                });
            check_in.click(function () {
                let time = moment().format('HH:mm');
                $.ajax({
                    url     : "{{ route('employees.checkin') }}",
                    type    : 'POST',
                    dataType: 'JSON',
                    data    : {time: time},
                })
                    .done(function () {
                        check_in.prop(disabled, true);
                    });
            })
            check_out.click(function () {
                let time = moment().format('HH:mm');
                $.ajax({
                    url     : "{{ route('employees.checkout') }}",
                    type    : 'POST',
                    dataType: 'JSON',
                    data    : {time: time},
                })
                    .done(function () {
                        check_out.prop(disabled, true);
                    })
            })
        })
	</script>
@endpush
