@extends('layout.master')
@include('accountants.menu')
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
	</style>
@endpush
@section('content')
	<div class="table-salary col-12">
		<div class="date w-100">
			Month: <label for="select-month"></label><select name="month" id="select-month"></select>
			Year: <label for="select-year"></label><select name="year" id="select-year"></select>
			<input type="hidden" style="width: 1.5em" name="month" value="" readonly>
			<input type="hidden" style="width: 3em" name="year" value="" readonly>
			<span class="btn btn-primary float-right m-1 btn-approve">Approve</span>
		</div>
		<table id="salary-table" class="table table-striped table-bordered w-100 table-sm" cellspacing="0"
		       width="100%">
			<thead>
			<th class="th-sm">#</th>
			<th class="th-sm">Avatar</th>
			<th class="th-sm">Name</th>
			<th class="th-sm">Department</th>
			<th class="th-sm">Role</th>
			<th class="th-sm">Work days</th>
			<th class="th-sm">Basic salary</th>
			<th class="th-sm">Overtime</th>
			<th class="th-sm">Deduction</th>
			<th class="th-sm">Salary</th>
			<th class="th-sm">Action</th>
			<th class="th-sm">
				<span>Approve</span>
			</th>
			</thead>
			<tbody>
			</tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination pagination-rounded mb-0 float-right" id="salary-pagination">
			</ul>
		</nav>
	</div>
	<div class="table-show-salary-detail d-none col-12">
		<div class="popup-show-salary-detail-content">
			<div class="card-header">
				<span class="card-title h2">Salary Detail</span>
				<button class="btn btn-danger btn-sm close-popup float-right">X</button>
			</div>
			<div class="popup-show-salary-detail-body">
				<table class="table table-striped table-bordered" id="table-salary-detail">
					<thead>
					<th class="col-4">
						<span class="detail-employee-name"></span>
					</th>
					<th class="am col-1">
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
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection
@push('js')
	<script>
        $(document).ready(async function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let slM = $('#select-month');
            let slY = $('#select-year');
            $('.close-popup').click(function () {
                $('.table-show-salary-detail').addClass('d-none');
                $('.table-salary').removeClass('d-none');

            });
            // table salary
            (function () {
                const d   = new Date();
                let month = d.getMonth();
                let year  = d.getFullYear();
                if (month === 0) {
                    month = 11;
                    year  = year - 1;
                }

                for (let i = year; i >= 2018; i--) {
                    slY.append(`<option value="${i}">${i}</option>`);
                }
                for (let i = month; i >= 1; i--) {
                    let j = i;
                    if (j <= 9) {
                        j = '0' + i;
                    }
                    slM.append(`<option value="${i}">${j}</option>`);
                }
                $('.date input[name="month"]').val(month);
                $('.date input[name="year"]').val(year);
            })()

            let detail_salary = $(".table-show-salary-detail");
            let month         = $('.date input[name="month"]').val();
            let year          = $('.date input[name="year"]').val();

            getSalary(month, year);

            function getSalary(month, year) {
                $('#salary-pagination').empty();

                $.ajax({
                    type    : "post",
                    url     : "{{ route('accountants.get_salary') }}",
                    data    : {
                        month: month,
                        year : year
                    },
                    dataType: "json",
                    success : function (response) {
                        $.each(response.data.data, function (k, v) {
                            /// do stuff
                            let img =
                                    `<img  src="{{ asset('') }}img/${v['emp'][0]['avatar']} "  style=" border-radius:50% " width="40px"/>`
                            if (v['emp'][0]['avatar'] === null) {
                                img =
                                    `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="40px">`
                            }
                            let approve = `<i class="mdi mdi-check-circle text-success"></i>`
                            if (v.acct_id == null) {
                                approve =
                                    ` <input type="checkbox" name="approve" class="check_box" data-id="${v['emp_id']}"
										data-dept_name="${v['dept_name']}" data-role_name="${v.role_name}"> `
                            }
                            $("#salary-table tbody").append($("<tr>")
                                .append($("<td class='am'>").append(k + 1))
                                .append($("<td class='am'>").append(img))
                                .append($("<td class='al'>").append(v['emp'][0]['fname'] + ' ' + v['emp'][0]['lname']))
                                .append($("<td class='am'>").append(v['dept_name']))
                                .append($("<td class='am'>").append(v['role_name']))
                                .append($("<td class='am'>").append(v['work_day']))
                                .append($("<td class='ar'>").append(v['pay_rate_money']))
                                .append($("<td class='ar'>").append(v['bonus_salary_total_off_work_day']))
                                .append($("<td class='ar'>").append(v['deduction_detail']))
                                .append($("<td class='ar'>").append(v['salary_money']))
                                .append($("<td class='am'>")
	                                .append(`<i class="fa-solid fa-eye btn-show-salary text-primary"
												data-id="${v['emp_id']}" data-dept_name="${v['dept_name']}"
												data-role_name="${v['role_name']}"></i>
                                        `))
                                .append($("<td class='am'>").append(approve))
                            );
                        });
                        showDetailSalary();
                        renderSalaryPagination(response.data.pagination);
                        changePage(month, year);
                    }
                });
            }

            function showDetailSalary() {
                $(".btn-show-salary").click(function () {
                    let id        = $(this).data('id');
                    let dept_name = $(this).data('dept_name');
                    let role_name = $(this).data('role_name');
                    let month     = $('.date input[name="month"]').val();
                    let year      = $('.date input[name="year"]').val();
                    $.ajax({
                        type    : "post",
                        url     : "{{ route('accountants.salary_detail') }}",
                        data    : {
                            id       : id,
                            dept_name: dept_name,
                            role_name: role_name,
                            month    : month,
                            year     : year
                        },
                        dataType: "json",
                        success : function (response) {
                            $('.table-show-salary-detail').removeClass('d-none');
                            $('.table-salary').addClass('d-none');
                            detail_salary.find(".detail-employee-name").text(response['salary']['emp'][0]['fname'] + ' ' + response['salary']['emp'][0]['lname']);
                            detail_salary.find(".detail-work_day").text(response['salary']['work_day']);
                            detail_salary.find(".detail-pay_rate").text(response['salary']['pay_rate_work_day']);
                            detail_salary.find(".detail-basic_salary").text(response['salary']['pay_rate_money']);
                            detail_salary.find(".detail-over_work_day").text(response['salary']['over_work_day']);
                            detail_salary.find(".detail-pay_rate_over_work_day").text(response['salary']['pay_rate_over_work_day']);
                            detail_salary.find(".detail-bonus_salary_over_work_day").text(response['salary']['bonus_salary_over_work_day']);
                            detail_salary.find(".detail-off_work_day").text(response['salary']['off_work_day']);
                            detail_salary.find(".detail-pay_rate_off_work_day").text(response['salary']['pay_rate_off_work_day']);
                            detail_salary.find(".detail-bonus_salary_off_work_day").text(response['salary']['bonus_salary_off_work_day']);
                            detail_salary.find(".detail-late_1").text(response['salary']['late_1']);
                            detail_salary.find(".detail-deduction_late_1").text(response['fines'][0]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_late_1").text(response['salary']['deduction_late_one_detail']);
                            detail_salary.find(".detail-late_2").text(response['salary']['late_2']);
                            detail_salary.find(".detail-deduction_late_2").text(response['fines'][1]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_late_2").text(response['salary']['deduction_late_two_detail']);
                            detail_salary.find(".detail-early_1").text(response['salary']['early_1']);
                            detail_salary.find(".detail-deduction_early_1").text(response['fines'][2]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_early_1").text(response['salary']['deduction_early_one_detail']);
                            detail_salary.find(".detail-early_2").text(response['salary']['early_2']);
                            detail_salary.find(".detail-deduction_early_2").text(response['fines'][3]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_early_2").text(response['salary']['deduction_early_two_detail']);
                            detail_salary.find(".detail-miss").text(response['salary']['miss']);
                            detail_salary.find(".detail-deduction_miss").text(response['fines'][4]['deduction_detail']);
                            detail_salary.find(".detail-deduction_salary_miss").text(response['salary']['deduction_miss_detail']);
                            detail_salary.find(".detail-salary").text(response['salary']['salary_money']);

                        }
                    });
                });
            }

            function changePage(month, year) {
                $(document).on('click', '#salary-pagination > li > a', function (event) {
                    event.preventDefault();
                    let url = $(this).attr('href');
                    if (url !== 'null') {
                        $('#salary-table').find('tbody').empty();
                        $.ajax({
                            url     : url,
                            method  : "POST",
                            datatype: 'json',
                            data    : {
                                month: month,
                                year : year,
                            },
                            success : function (response) {
                                $.each(response.data.data, function (k, v) {
                                    /// do stuff
	                                let img =
                                    `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="30px">`
                                    let approve =
                                            ` <input type="checkbox" name="sign" class="check_box" data-id="${v['emp_id']}" data-dept_name="${v['dept_name']}" data-role_name="${v['role_name']}"> `

                                    if (v['emp'][0]['avatar']) {
                                        img =
	                                        `<img  src="{{ asset('') }}img/${v['emp'][0]['avatar']} "  style=" border-radius:50% " width="30px"/>`
                                    }
                                    if (v.sign) {
                                        approve = `<i class="mdi mdi-check-circle text-success"></i>`
                                    }
                                    $("#salary-table tbody").append($("<tr>")
                                        .append($("<td class='am'>").append(k + 1))
                                        .append($("<td class='am'>").append(img))
                                        .append($("<td class='al'>").append(v['emp'][0]['fname'] + ' ' + v['emp'][0]['lname']))
                                        .append($("<td class='am'>").append(v['dept_name']))
                                        .append($("<td class='am'>").append(v['role_name']))
                                        .append($("<td class='am'>").append(v['work_day']))
                                        .append($("<td class='ar'>").append(v['pay_rate_money']))
                                        .append($("<td class='ar'>").append(v['bonus_salary_over_work_day']))
                                        .append($("<td class='ar'>").append(v['deduction_detail']))
                                        .append($("<td class='ar'>").append(v['salary_money']))
                                        .append($("<td class='am'>").append(`<i class="fa-solid fa-eye btn-show-salary text-primary" 
														data-id="${v['emp_id']}" data-dept_name="${v['dept_name']}" 
														data-role_name="${v['role_name']}"></i> `))
                                        .append($("<td class='am'>").append(approve))
                                    );
                                });
                                $('#salary-pagination').empty();
                                showDetailSalary();
                                renderSalaryPagination(response['data']['pagination']);
                            }
                        });
                    }
                });
            }

            function renderSalaryPagination(links) {
                links.forEach(function (each) {
                    $('#salary-pagination').append($('<li>').attr('class',
                        `page-item ${each.active ? 'active' : ''}`)
                        .append(`<a class="page-link"
                                    href="${each.url}">
                                        ${each.label}
                                    </a>
                                `))
                })
            }

            slM.change(function (e) {
                month = $(this).val();
                $("#salary-table tbody").empty();
                getSalary(month, year);
            });
            slY.change(function (e) {
                year = $(this).val();
                if (slY.val() < (new Date()).getFullYear()) {
                    month = 12;
                    slM.empty();
                    for (let i = month; i >= 1; i--) {
                        let j = i;
                        if (j <= 9) {
                            j = '0' + i;
                        }
                        slM.append(`<option value="${i}">${j}</option>`);
                    }
                } else {
                    month = (new Date()).getMonth();
                    slM.empty();
                    for (let i = month; i >= 1; i--) {
                        let j = i;
                        if (j <= 9) {
                            j = '0' + i;
                        }
                        slM.append(`<option value="${i}">${j}</option>`);
                    }
                }
                $("#salary-table tbody").empty();
                getSalary(month, year);
            });

            $(".btn-approve").click(function () {
                let data = [];
                $('input[name="approve"]:checked').each(function () {
                    let obj          = {};
                    obj['id']        = $(this).data('id');
                    obj['dept_name'] = $(this).data('dept_name');
                    obj['role_name'] = $(this).data('role_name');
                    obj['month']     = $('.date input[name="month"]').val();
                    obj['year']      = $('.date input[name="year"]').val();
                    data.push(obj);
                });
                let data_to_send = JSON.stringify({data});
                if (data.length > 0) {
                    $.ajax({
                        type       : "post",
                        url        : "{{ route('accountants.approve') }}",
                        data       : data_to_send,
                        contentType: "application/json; charset=utf-8",
                        dataType   : "json",
                        success    : function (response) {
                            if (response.success === true) {
                                $.toast({
                                    heading           : response.data.message,
                                    text              : '',
                                    icon              : 'success',
                                    showHideTransition: 'slide',
                                    allowToastClose   : false,
                                    hideAfter         : 3000,
                                    stack             : 5,
                                    position          : 'top-right',
                                    textAlign         : 'left',
                                    loader            : true,
                                });
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            } else {
                                $.toast({
                                    heading           : response.data.message,
                                    text              : '',
                                    icon              : 'error',
                                    showHideTransition: 'slide',
                                    allowToastClose   : false,
                                    hideAfter         : 3000,
                                    stack             : 5,
                                    position          : 'top-right',
                                    textAlign         : 'left',
                                    loader            : true,
                                });
                            }
                        }
                    });
                }
            });
        });
	</script>
@endpush