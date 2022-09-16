@extends('layout.master')
@include('ceo.menu')
@push('css')
	<style>
        th, td {
            text-align: center;
            margin: auto;
            vertical-align: middle !important;
            height: 75px;
        }

        input[readonly] {
            background-color: white !important;
        }
	</style>
@endpush
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
	<div class="fines col-12">
		<div class="col-12 p-2 border border-0 border-light fines-details">
			<table class="table table-striped table-bordered">
				<thead>
				<th>#</th>
				<th>Name</th>
				<th>Fines</th>
				<th>Deduction</th>
				<th>Action</th>
				</thead>
				<tbody class="roles_list_body">
				@foreach ($fines as $each)
					<tr>
						<form class="change-fines" method="POST" action="">
							@csrf
							<td class="col-1 text-danger">
								<div class="input">
									<span>{{ $each->id }}</span>
								</div>
								<input type="hidden" class="form-control inp-fines-id" name="id"
								       value=" {{ $each->id }}" readonly>
							</td>
							<td class="col-3">
								<span class="fines_name input">
									{{ $each->name }}
								</span>
								<label>
									<input type="text" class="form-control inp-fines-name d-none" name="name"
									       value="{{ $each->name }}">
								</label>
							</td>
							<td class="col-3 align-middle">
								<span class="fines_time input">
									{{ $each->fines_time }} minutes
								</span>
								<label>
									<input type="text" class="form-control inp-fines-time d-none" name="fines"
									       value="{{ $each->fines_time }}" readonly>
								</label>
							</td>
							<td class="col-3">
								<span class="deduction_detail input">
									{{ $each->deduction_detail }}
								</span>
								<label>
									<input type="text" class="form-control inp-deduction d-none" name="deduction"
									       pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" data-type="currency"
									       value="{{ $each->deduction }}">
								</label>
							</td>
							<td class="col-2">
								<div>
									<i class="btn-change-fines fa-solid fa-pen btn-edit-role text-warning"></i>
									<i class="fa-solid btn-submit-change-fines fa-circle-check text-success d-none"></i>
									<i class="fa-solid btn-cancel-change-fines fa-circle-xmark text-danger d-none"></i>
								</div>
							</td>
						</form>
					</tr>
				@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection
@push('js')
	// searching by department
	<script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-change-fines').click(function () {
                $(this).addClass('d-none');
                let tr = $(this).parents('tr');
                tr.find('.btn-submit-change-fines').removeClass('d-none');
                tr.find('.btn-cancel-change-fines').removeClass('d-none');
                tr.find('.inp-deduction').removeClass('d-none');
                tr.find('.inp-fines-name').removeClass('d-none');
                tr.find('.inp-fines-time').removeClass('d-none');
                tr.find('.fines_time').addClass('d-none');
                tr.find('.fines_name').addClass('d-none');
                tr.find('.deduction_detail').addClass('d-none');
            });
            $('.btn-cancel-change-fines').click(function () {
                $(this).addClass('d-none');
                let tr = $(this).parents('tr');
                tr.find('.btn-submit-change-fines').addClass('d-none');
                tr.find('.btn-change-fines').removeClass('d-none');
                tr.find('.inp-deduction').addClass('d-none');
                tr.find('.inp-fines-name').addClass('d-none');
                tr.find('.inp-fines-time').addClass('d-none');
                tr.find('.fines_time').removeClass('d-none');
                tr.find('.fines_name').removeClass('d-none');
                tr.find('.deduction_detail').removeClass('d-none');
            });
            $('.btn-submit-change-fines').click(function () {
                let this_btn      = $(this);
                let tr            = $(this).parents('tr');
                let id            = tr.find('.inp-fines-id').val();
                let deduction_val = tr.find('.inp-deduction').val();
                let deduction     = deduction_val.replace(/[^0-9\.]+/g, "");
                let name          = tr.find('.inp-fines-name').val();
                let fines         = tr.find('.inp-fines-time').val();
                $.ajax({
                    url     : "{{ route('ceo.fines_update') }}",
                    method  : "POST",
                    datatype: 'json',
                    data    : {
                        id       : id,
                        name     : name,
                        fines    : fines,
                        deduction: deduction,
                    },
                    success : function (response) {
                        console.log('2');
                        this_btn.addClass('d-none');
                        tr.find('.btn-change-fines').removeClass('d-none');
                        tr.find('.btn-cancel-change-fines').addClass('d-none');
                        tr.find('.inp-deduction').addClass('d-none');
                        tr.find('.inp-fines-name').addClass('d-none');
                        tr.find('.inp-fines-time').addClass('d-none');
                        tr.find('.fines_name').text(response[0]["name"]);
                        tr.find('.deduction_detail').text(response[0]["deduction_detail"]);
                        tr.find('.fines_time').removeClass('d-none');
                        tr.find('.fines_name').removeClass('d-none');
                        tr.find('.deduction_detail').removeClass('d-none');

                    }
                })
            });
            let currencyInput = document.querySelector('input[data-type="currency"]')
            let currency      = 'VND'; // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

            // format initial value
            onBlur({target: currencyInput})
            currencyInput.addEventListener('focus', onFocus)
            currencyInput.addEventListener('blur', onBlur)


            function localStringToNumber(s) {
                return Number(String(s).replace(/[^0-9.-]+/g, ""))
            }

            function onFocus(e) {
                let value      = e.target.value;
                e.target.value = value ? localStringToNumber(value) : ''
            }

            function onBlur(e) {
                let value = e.target.value

                let options = {
                    maximumFractionDigits: 2,
                    currency             : currency,
                    style                : "currency",
                    currencyDisplay      : "symbol"
                }

                e.target.value = (value || value === 0)
                    ? localStringToNumber(value).toLocaleString(undefined, options)
                    : ''
            }
        });
	</script>
@endpush
