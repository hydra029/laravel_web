@extends('layout.master')
@include('employees.menu')
@push('css')
	<style>
        tr, th, td {
            vertical-align: middle !important;
        }

        .am, #salary-table th {
            text-align: center !important;
        }

        .ar {
            text-align: right !important;
        }

        .al {
            text-align: left !important;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
        }
	</style>
@endpush
@section('content')
	<div class="table-show-salary-detail col-12">
		<div class="card-header pb-4">
			<div class="col-3 al date">
				Month: <label for="select-month"></label><select name="month" id="select-month"></select>
				Year: <label for="select-year"></label><select name="year" id="select-year"></select>
				<input type="hidden" style="width: 1.5em" name="month" value="" readonly>
				<input type="hidden" style="width: 3em" name="year" value="" readonly>
				<button type="button" class="d-none" id="btn-data" data-id="{{ session('id') }}"
				        data-dept="{{ session('dept_name') }}" data-role="{{ session('role_name') }}"></button>
			</div>
			<div class="col-6 am">
				<span class="card-title h2">Salary Detail</span>
			</div>
			<div class="col-3 ar"></div>
		</div>
		<div>
			<div class="am d-none" id="empty">
				<h3>There is no record in the database !!!</h3>
			</div>
			<table class="table table-striped table-bordered" id="table-salary-detail">
				<thead>
				<th class="col-3">
				</th>
				<th class="am col-2">
					Unit
				</th>
				<th class="am col-1">
					Quantity
				</th>
				<th class="am col-3">
					Base
				</th>
				<th class="am col-3">
					Total
				</th>
				</thead>
				<tbody>
				<tr>
					<th>Work day</th>
					<td class="am">Days</td>
					<td class="am">
						<span class="detail-work_day"></span>
					</td>
					<td class="ar">
						<span class="detail-pay_rate"></span>
					</td>
					<td class="text-right">
						<span class="detail-basic_salary"></span>
					</td>
				</tr>
				<tr>
					<th>Over time work day</th>
					<td class="am">Days</td>
					<td class="am">
						<span class="detail-over_work_day"></span>
					</td>
					<td class="ar">
						<span class="detail-pay_rate_over_work_day"></span>
					</td>
					<td class="text-right">
						<span class="detail-bonus_salary_over_work_day"></span>
					</td>
				</tr>
				<tr>
					<th>Off time work day</th>
					<td class="am">Days</td>
					<td class="am">
						<span class="detail-off_work_day"></span>
					</td>
					<td class="ar">
						<span class="detail-pay_rate_off_work_day"></span>
					</td>
					<td class="text-right">
						<span class="detail-bonus_salary_off_work_day"></span>
					</td>
				</tr>
				<tr>
					<th>Check in late 1</th>
					<td class="am">Time(s)</td>
					<td class="am">
						<span class="detail-late_1"></span>
					</td>
					<td class="ar">
						<span class="detail-deduction_late_1"></span>
					</td>
					<td class="text-right">
						<span class="detail-deduction_salary_late_1"></span>
					</td>
				</tr>
				<tr>
					<th>Check in late 2</th>
					<td class="am">Time(s)</td>
					<td class="am">
						<span class="detail-late_2"></span>
					</td>
					<td class="ar">
						<span class="detail-deduction_late_2"></span>
					</td>
					<td class="text-right">
						<span class="detail-deduction_salary_late_2"></span>
					</td>
				</tr>
				<tr>
					<th>Check out early 1</th>
					<td class="am">Time(s)</td>
					<td class="am">
						<span class="detail-early_1"></span>
					</td>
					<td class="ar">
						<span class="detail-deduction_early_1"></span>
					</td>
					<td class="text-right">
						<span class="detail-deduction_salary_early_1"></span>
					</td>
				</tr>
				<tr>
					<th>Check out early 2</th>
					<td class="am">Time(s)</td>
					<td class="am">
						<span class="detail-early_2"></span>
					</td>
					<td class="ar">
						<span class="detail-deduction_early_2"></span>
					</td>
					<td class="text-right">
						<span class="detail-deduction_salary_early_2"></span>
					</td>
				</tr>
				<tr>
					<th>Miss</th>
					<td class="am">Time(s)</td>
					<td class="am">
						<span class="detail-miss"></span>
					</td>
					<td class="ar">
						<span class="detail-deduction_miss"></span>
					</td>
					<td class="text-right">
						<span class="detail-deduction_salary_miss"></span>
					</td>
				</tr>
				<tr>
					<th>Total</th>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">
						<b class="detail-salary"></b>
					</td>
				</tr>
				<tr>
					<td colspan="5" class="am">
						<button class="btn btn-success btn-confirm d-none">Confirm</button>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection
@push('js')
	<script>
        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let slM           = $('#select-month');
            let slY           = $('#select-year');
            let btnConfirm    = $('.btn-confirm');
            let btn           = $('#btn-data');
            let detail_salary = $("#table-salary-detail");
            let empty         = $("#empty");
            let currentDate  = new Date().getDate();
            let currentMonth  = new Date().getMonth();
            let currentYear   = new Date().getFullYear();
            (function () {
                if (currentMonth === 0) {
                    currentMonth = 11;
                    currentYear  = currentYear - 1;
                }

                for (let i = currentYear; i >= 2018; i--) {
                    slY.append(`<option value="${i}">${i}</option>`);
                }
                for (let i = currentMonth; i >= 1; i--) {
                    let j = i;
                    if (j <= 9) {
                        j = '0' + i;
                    }
                    slM.append(`<option value="${i}">${j}</option>`);
                }
                slM.val(currentMonth);
                slY.val(currentYear);
            })()
            showDetailSalary();
            slM.change(function () {
                showDetailSalary();
            });
            slY.change(function () {
                showDetailSalary();
            });

            function showDetailSalary() {
                let id        = btn.data('id');
                let dept_name = btn.data('dept');
                let role_name = btn.data('role');
                let month     = slM.val();
                let year      = slY.val();
                $.ajax({
                    type    : "post",
                    url     : "{{ route('employees.get_personal_salary') }}",
                    data    : {
                        id       : id,
                        dept_name: dept_name,
                        role_name: role_name,
                        month    : month,
                        year     : year
                    },
                    dataType: "json",
                    success : function (response) {
                        if (response === 0) {
                            empty.has('d-none') && empty.removeClass('d-none');
                            detail_salary.addClass('d-none');
                        } else {
                            detail_salary.has('d-none') && detail_salary.removeClass('d-none');
                            empty.addClass('d-none');
                            detail_salary.find(".detail-work_day")
                                .text(response['salary']['work_day']);
                            detail_salary.find(".detail-pay_rate")
                                .text(response['salary']['pay_rate_work_day']);
                            detail_salary.find(".detail-basic_salary")
                                .text(response['salary']['pay_rate_money']);
                            detail_salary.find(".detail-over_work_day")
                                .text(response['salary']['over_work_day']);
                            detail_salary.find(".detail-pay_rate_over_work_day")
                                .text(response['salary']['pay_rate_over_work_day']);
                            detail_salary.find(".detail-bonus_salary_over_work_day")
                                .text(response['salary']['bonus_salary_over_work_day']);
                            detail_salary.find(".detail-off_work_day")
                                .text(response['salary']['off_work_day']);
                            detail_salary.find(".detail-pay_rate_off_work_day")
                                .text(response['salary']['pay_rate_off_work_day']);
                            detail_salary.find(".detail-bonus_salary_off_work_day")
                                .text(response['salary']['bonus_salary_off_work_day']);
                            detail_salary.find(".detail-late_1")
                                .text(response['salary']['late_1']);
                            detail_salary.find(".detail-deduction_late_1")
                                .text(response['fines'][0]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_late_1")
                                .text(response['salary']['deduction_late_one_detail']);
                            detail_salary.find(".detail-late_2")
                                .text(response['salary']['late_2']);
                            detail_salary.find(".detail-deduction_late_2")
                                .text(response['fines'][1]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_late_2")
                                .text(response['salary']['deduction_late_two_detail']);
                            detail_salary.find(".detail-early_1")
                                .text(response['salary']['early_1']);
                            detail_salary.find(".detail-deduction_early_1")
                                .text(response['fines'][2]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_early_1")
                                .text(response['salary']['deduction_early_one_detail']);
                            detail_salary.find(".detail-early_2")
                                .text(response['salary']['early_2']);
                            detail_salary.find(".detail-deduction_early_2")
                                .text(response['fines'][3]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_early_2")
                                .text(response['salary']['deduction_early_two_detail']);
                            detail_salary.find(".detail-miss")
                                .text(response['salary']['miss']);
                            detail_salary.find(".detail-deduction_miss")
                                .text(response['fines'][4]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_miss")
                                .text(response['salary']['deduction_miss_detail']);
                            detail_salary.find(".detail-salary")
                                .text(response['salary']['salary_money']);
                        }
                        if (month - 0 === currentMonth - 1 && year - 0 === currentYear) {
                            if (currentDate >= 15 && currentDate <= 25) {
                                btnConfirm.removeClass('d-none');
                            }
                        }
                    }
                });
            }

            btnConfirm.click(function () {
                $.ajax({
                    url     : '{{route('employees.confirm_salary')}}',
                    dataType: 'json',
                    method  : 'POST',
                })
                    .done(function (response) {
                        if (response === 0) {
                            notifySuccess("You\'ve successfully signed salary !");
                            btnConfirm.addClass('d-none');
                        } else {
                            notifyError('Today is not the day to sign the salary !')
                        }
                    })
            })
        })
	</script>
@endpush