@extends('layout.master')
@include('ceo.menu')
@section('content')
	@push('css')
		<style>
            td {
                height: 100px;
            }
		</style>
		<link rel="stylesheet" type="text/css"
		      href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
	@endpush
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif
	<table class="table table-striped table-centered mb-20 table-bordered text-center"
	       style="border-color: crimson !important;" id="student-table-index">
		<thead>
		<tr>
			<th rowspan="2">Shift</th>
			<th colspan="4">Check In</th>
			<th colspan="4">Check Out</th>
			<th rowspan="2">Action</th>
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
		<tbody>
		@foreach($time as $each)
			<tr>
				<form class="form-time-change" method="post">
					<td>
						<div class="shift-name">
							{{$each -> shift_name}}
						</div>
						<label class="shift-name-inp d-none">
							<input type="text" name="id" class="form-control text-center"
							       placeholder="{{$each -> shift_name}}" value="{{$each -> id}}">
						</label>
					</td>
					<td>
						<div class="shift-in-start">
							{{$each -> in_start}}
						</div>
						<label class="shift-in-start-inp d-none">
							<input type="text" name="check_in_start" class="form-control text-center"
							       placeholder="{{$each -> in_start}}" value="{{$each -> in_start}}">
						</label>
					</td>
					<td>
						<div class="shift-in-end">
							{{$each -> in_end}}
						</div>
						<label class="shift-in-end-inp d-none">
							<input type="text" name="check_in_end" class="form-control text-center"
							       placeholder="{{$each -> in_end}}" value="{{$each -> in_end}}">
						</label>
					</td>
					<td>
						<div class="shift-in-late-1">
							{{$each -> in_late_1}}
						</div>
						<label class="shift-in-late-1-inp d-none">
							<input type="text" name="check_in_late_1" class="form-control text-center"
							       placeholder="{{$each -> in_late_1}}" value="{{$each -> in_late_1}}">
						</label>
					</td>
					<td>
						<div class="shift-in-late-2">
							{{$each -> in_late_2}}
						</div>
						<label class="shift-in-late-2-inp d-none">
							<input type="text" name="check_in_late_2" class="form-control text-center"
							       placeholder="{{$each -> in_late_2}}" value="{{$each -> in_late_2}}">
						</label>
					</td>
					<td>
						<div class="shift-out-early-1">
							{{$each -> out_early_1}}
						</div>
						<label class="shift-out-early-1-inp d-none">
							<input type="text" name="check_out_early_1" class="form-control text-center"
							       placeholder="{{$each -> out_early_1}}" value="{{$each -> out_early_1}}">
						</label>
					</td>
					<td>
						<div class="shift-out-early-2">
							{{$each -> out_early_2}}
						</div>
						<label class="shift-out-early-2-inp d-none">
							<input type="text" name="check_out_early_2" class="form-control text-center"
							       placeholder="{{$each -> out_early_2}}" value="{{$each -> out_early_2}}">
						</label>
					</td>
					<td>
						<div class="shift-out-start">
							{{$each -> out_start}}
						</div>
						<label class="shift-out-start-inp d-none">
							<input type="text" name="check_out_start" class="form-control text-center"
							       placeholder="{{$each -> out_start}}" value="{{$each -> out_start}}">
						</label>
					</td>
					<td>
						<div class="shift-out-end">
							{{$each -> out_end}}
						</div>
						<label class="shift-out-end-inp d-none">
							<input type="text" name="check_out_end" class="form-control text-center"
							       placeholder="{{$each -> out_end}}" value="{{$each -> out_end}}">
						</label>
					</td>
					<td>
						<button type="button" class="btn btn-primary btn-change">
							Change
						</button>
						<button type="button" class="btn btn-primary btn-save d-none" data-id="{{$each->id}}">
							Save
						</button>
					</td>
				</form>
			</tr>
		@endforeach
		</tbody>
	</table>
@endsection
@push('js')
	<script type="text/javascript">
        $(document).ready(function () {
            $('td').attr('class', 'col-1');
            $('label').addClass('mb-0');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-change').click(function () {
                $(this).addClass('d-none');
                $(this).parents('tr')
                    .find('.btn-save, .shift-in-start-inp, .shift-in-end-inp, .shift-in-late-1-inp, .shift-in-late-2-inp, .shift-out-early-1-inp, .shift-out-early-2-inp, .shift-out-start-inp, .shift-out-end-inp')
                    .removeClass('d-none');
                $(this).parents('tr')
                    .find('.shift-in-start, .shift-in-end, .shift-in-late-1, .shift-in-late-2, .shift-out-early-1, .shift-out-early-2, .shift-out-start, .shift-out-end')
                    .addClass('d-none');
            });
            $('.btn-save').click(function () {
                let tr                    = $(this).parents('tr');
                let form                  = tr.find('form');
                const time_regex          = /^([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d)$/;
                let check_in_start_inp    = tr.find('.shift-in-start-inp').find('input').val();
                let check_in_end_inp      = tr.find('.shift-in-end-inp').find('input').val();
                let check_in_late_1_inp   = tr.find('.shift-in-late-1-inp').find('input').val();
                let check_in_late_2_inp   = tr.find('.shift-in-late-2-inp').find('input').val();
                let check_out_early_1_inp = tr.find('.shift-out-early-1-inp').find('input').val();
                let check_out_early_2_inp = tr.find('.shift-out-early-2-inp').find('input').val();
                let check_out_start_inp   = tr.find('.shift-out-start-inp').find('input').val();
                let check_out_end_inp     = tr.find('.shift-out-end-inp').find('input').val();
                let text                  = check_in_start_inp.concat(" ", check_in_end_inp).concat(" ", check_in_late_1_inp).concat(" ", check_in_late_2_inp).concat(" ", check_out_early_1_inp).concat(" ", check_out_early_2_inp).concat(" ", check_out_start_inp).concat(" ", check_out_end_inp);
                if (text.match(time_regex)) {
                    $.ajax({
                        url     : "{{ route('ceo.time_change') }}",
                        type    : 'POST',
                        dataType: 'JSON',
                        data    : form.serializeArray(),
                    })
                        .done(function (response) {
                            tr.find('.btn-change, .shift-name, .shift-in-start, .shift-in-end, .shift-in-late-1, .shift-in-late-2, .shift-out-early-1, .shift-out-early-2, .shift-out-start, .shift-out-end')
                                .removeClass('d-none');
                            tr.find('.btn-save, .shift-in-start-inp, .shift-in-end-inp, .shift-in-late-1-inp, .shift-in-late-2-inp, .shift-out-early-1-inp, .shift-out-early-2-inp, .shift-out-start-inp, .shift-out-end-inp')
                                .addClass('d-none');
                            tr.find('.shift-in-start').text(response["check_in_start"].slice(0, 5));
                            tr.find('.shift-in-end').text(response["check_in_end"].slice(0, 5));
                            tr.find('.shift-in-late-1').text(response["check_in_late_1"].slice(0, 5));
                            tr.find('.shift-in-late-2').text(response["check_in_late_2"].slice(0, 5));
                            tr.find('.shift-out-early-1').text(response["check_out_early_1"].slice(0, 5));
                            tr.find('.shift-out-early-2').text(response["check_out_early_2"].slice(0, 5));
                            tr.find('.shift-out-start').text(response["check_out_start"].slice(0, 5));
                            tr.find('.shift-out-end').text(response["check_out_end"].slice(0, 5));
                            tr.find('.shift-in-start').attr('placeholder', response["check_in_start"].slice(0, 5));
                            tr.find('.shift-in-end').attr('placeholder', response["check_in_end"].slice(0, 5));
                            tr.find('.shift-in-late-1').attr('placeholder', response["check_in_late_1"].slice(0, 5));
                            tr.find('.shift-in-late-2').attr('placeholder', response["check_in_late_2"].slice(0, 5));
                            tr.find('.shift-out-early-1').attr('placeholder', response["check_out_early_1"].slice(0, 5));
                            tr.find('.shift-out-early-2').attr('placeholder', response["check_out_early_2"].slice(0, 5));
                            tr.find('.shift-out-start').attr('placeholder', response["check_out_start"].slice(0, 5));
                            tr.find('.shift-out-end').attr('placeholder', response["check_out_end"].slice(0, 5));
                            $.toast({
                                heading  : 'Action completed',
                                text     : "You\'ve changed time shift successfully",
                                icon     : 'success',
                                position : 'top-right',
                                hideAfter: 2000,
                            });

                        })
                        .fail(function () {
                            $.toast({
                                heading  : 'Something went wrong',
                                text     : "Your time input format is incorrect",
                                icon     : 'success',
                                position : 'top-right',
                                hideAfter: 2000,
                            });
                        })
                } else {
                    $.toast({
                        heading  : 'Something went wrong',
                        text     : 'Your input data is not time',
                        icon     : 'error',
                        position : 'top-right',
                        hideAfter: 2000,
                    });
                }
            });

            let inp = $(':input');
            inp.on('keydown', function (e) {
                e.preventDefault();
                const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d)$/;
                let value        = $(this).val();
                let placeholder  = $(this).attr('placeholder');
                let len          = value.length;
                let val          = value.split('');
                if (e.keyCode === 8) {
                    if (len === 3) {
                        value = val[0] + val[1];
                    } else {
                        value = '';
                        for (let i = 0; i < len - 2; i++) {
                            value += val[i];
                        }
                    }
                } else if (e.key >= 0 && e.key <= 9) {
                    if (len === 2) {
                        value += ':' + e.key;
                    } else if (len === 5) {
                        if (value.match(time_regex)) {
                            placeholder = $(this).val();
                            $(this).attr('placeholder', placeholder);
                            value = e.key;
                        } else {
                            $(this).val('');
                            $(this).text('');
                        }
                    } else {
                        value += e.key;
                    }
                } else if (value.match(time_regex) === true && (e.key === 27 || e.key === 13)) {
                    $(this).attr('placeholder', value);
                    inp.blur();
                } else {
                    let value = $(this).val();
                    if (value === '' || value.match(time_regex) === false) {
                        let placeholder = $(this).attr('placeholder');
                        $(this).val(placeholder);
                    }
                    inp.blur();
                }
                $(this).val(value);
            })
                .on('click', function () {
                    $(this).val('');
                })
                .blur(function () {
                    const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d)$/;
                    let value        = $(this).val();
                    if (value === '' || !value.match(time_regex)) {
                        let placeholder = $(this).attr('placeholder');
                        $(this).val(placeholder);
                    }
                })
        });
	</script>
@endpush
