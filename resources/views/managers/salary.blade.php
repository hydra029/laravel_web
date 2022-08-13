@extends('layout.master')
@include('managers.menu')
@section('content')
<div class="table-salary col-12">
    <div class="date w-100" >
        Month <input type="text" style="width: 1.5em" name="month" value="" readonly>
        Year <input type="text" style="width: 3em" name="year" value="" readonly>
        <span class="d-none dept_id">{{ session()->get('dept_id') }}</span>
    </div>
    <table id="salary-table" class="table table-striped w-100 text-center"  cellspacing="0" cellpadding="0" width="100%" height="100%">
        <thead>
                <th>#</th>
                <th></th>
                <th>Name</th>
                <th>Department</th>
                <th>Role</th>
                <th>Work days</th>
                <th>Basic salary</th>
                <th>Allowance</th>
                <th>Deduction</th>
                <th>Salary</th>
                <th>Action</th>
        </thead>
        <tbody>

        </tbody>
    </table>

</div>

<div class="table-show-salary-detail d-none col-12" >
    <div class="popup-show-salary-detail-content">
        <div class="card-header">
            <span class="card-title h2">Salary Detail</span>
            <button class="btn btn-danger btn-sm close-popup float-right">X</button>
        </div>
        <div class="popup-show-salary-detail-body">
            <table class="table table-striped table-bordered" id="table-salary-detail" >
                <thead>
                    <th>
                        <span class="detail-employee-name"></span>
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <tr>
                        <td>Work day</td>
                        <td>Days</td>
                        <td>
                            <span class="detail-work_day"></span>
                        </td>
                        <td>
                            <span class="detail-pay_rate"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-basic_salary"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Over time work day</td>
                        <td>Days</td>
                        <td>
                            <span class="detail-over_work_day"></span>
                        </td>
                        <td>
                            <span class="detail-pay_rate_over_work_day"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-bounus_salary_over_work_day"></span>
                        </td>
                        
                    </tr>
                    <tr>
                        <td>Check in late 1</td>
                        <td>Time(s)</td>
                        <td>
                            <span class="detail-late_1"></span>
                        </td>
                        <td>
                            <span class="detail-deduction_late_1"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-deduction_salary_late_1"></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Check in late 2</td>
                        <td>Time(s)</td>
                        <td>
                            <span class="detail-late_2"></span>
                        </td>
                        <td>
                            <span class="detail-deduction_late_2"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-deduction_salary_late_2"></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Check out early 1</td>
                        <td>Time(s)</td>
                        <td>
                            <span class="detail-early_1"></span>
                        </td>
                        <td>
                            <span class="detail-deduction_early_1"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-deduction_salary_early_1"></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Check out early 2</td>
                        <td>Time(s)</td>
                        <td>
                            <span class="detail-early_2"></span>
                        </td>
                        <td>
                            <span class="detail-deduction_early_2"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-deduction_salary_early_2"></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Miss</td>
                        <td>Time(s)</td>
                        <td>
                            <span class="detail-miss"></span>
                        </td>
                        <td>
                            <span class="detail-deduction_miss"></span>
                        </td>
                        <td class="text-right">
                            <span class="detail-deduction_salary_miss"></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            <span class="detail-salary"></span>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
</div>
@endsection
@push('js')
<script src="{{ asset('js/main.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(async function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            
            $('.close-popup').click(function() {
                $('.table-show-salary-detail').addClass('d-none');
                $('.table-salary').removeClass('d-none');
                
            });
            // table salary
                (function (){
                    const d = new Date();
                    let month = d.getMonth();
                    let year = d.getFullYear();
                    if (month == 1) {
                        month = 12;
                        year = year - 1;
                    }else {
                        month = month - 1;
                    }
                    $('.date input[name="month"]').val(month);
                    $('.date input[name="year"]').val(year);
                })()
                var dept_id = $('.dept_id').text();
                var detail_salary = $(".table-show-salary-detail");
                var month =  $('.date input[name="month"]').val();
                var year =   $('.date input[name="year"]').val();
                $.ajax({
                    type: "post",
                    url: "{{ route('managers.get_salary') }}",
                    data: {
                        dept_id: dept_id,
                        month: month,
                        year: year
                    },
                    dataType: "json",
                    success: function (response) {
                        $.each(response, function(k, v) {
                            /// do stuff
                            if (v.emp[0].avatar == null) {
                                var img =
                                    `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="40px">`
                            } else {
                                var img =
                                    `<img  src="{{ asset('') }}img/${v.emp[0].avatar} "  style=" border-radius:50% " width="40px"/>`
                            }
                            $("#salary-table tbody").append($("<tr>")
                                .append($("<td class='align-middle'>").append( k + 1 ))
                                .append($("<td class='align-middle'>").append( img ))
                                .append($("<td class='align-middle'>").append( v.emp[0].fname + ' ' + v.emp[0].lname ))
                                .append($("<td class='align-middle'>").append( v.dept_name ))
                                .append($("<td class='align-middle'>").append( v.role_name ))
                                .append($("<td class='align-middle'>").append( v.work_day ))
                                .append($("<td class='align-middle'>").append( v.pay_rate_money ))
                                .append($("<td class='align-middle'>").append( v.bounus_salary_over_work_day ))
                                .append($("<td class='align-middle'>").append( v.deduction_detail ))
                                .append($("<td class='align-middle'>").append( v.salary_money ))
                                .append($("<td class='align-middle'>").append( `
                                            <i class="fa-solid fa-eye btn-show-salary text-primary" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i>
                                    ` ))
                                    );
                        });
                        showDetailSalary();
                    }
                });
                $(".checkAll").click(function() {
                    if (this.checked) {
                        $(".check_box").prop("checked", true);
                    } else {
                        $(".check_box").prop("checked", false);
                    }  
                });

                function showDetailSalary(){
                    $(".btn-show-salary").click(function() {
                        var id = $(this).data('id');
                        var dept_name = $(this).data('dept_name');
                        var role_name = $(this).data('role_name');
                        var month =  $('.date input[name="month"]').val();
                        var year =   $('.date input[name="year"]').val();
                        $.ajax({
                            type: "post",
                            url: "{{ route('managers.salary_detail') }}",
                            data: {
                                id: id,
                                dept_name : dept_name,
                                role_name : role_name,
                                month: month,
                                year: year
                            },
                            dataType: "json",
                            success: function (response) {
                                $('.table-show-salary-detail').removeClass('d-none');
                                $('.table-salary').addClass('d-none');
                                detail_salary.find(".detail-employee-name").text(response.salary.emp[0].fname + ' ' + response.salary.emp[0].lname);
                                detail_salary.find(".detail-work_day").text(response.salary.work_day);
                                detail_salary.find(".detail-pay_rate").text(response.salary.pay_rate_work_day);
                                detail_salary.find(".detail-basic_salary").text(response.salary.pay_rate_money);
                                detail_salary.find(".detail-over_work_day").text(response.salary.over_work_day);
                                detail_salary.find(".detail-pay_rate_over_work_day").text(response.salary.pay_rate_over_work_day);
                                detail_salary.find(".detail-bounus_salary_over_work_day").text(response.salary.bounus_salary_over_work_day);
                                detail_salary.find(".detail-late_1").text(response.salary.late_1);
                                detail_salary.find(".detail-deduction_late_1").text(response.fines[0].deduction_detail);
                                detail_salary.find(".detail-deduction_salary_late_1").text(response.salary.deduction_late_one_detail );
                                detail_salary.find(".detail-late_2").text(response.salary.late_2);
                                detail_salary.find(".detail-deduction_late_2").text(response.fines[1].deduction_detail);
                                detail_salary.find(".detail-deduction_salary_late_2").text(response.salary.deduction_late_two_detail );
                                detail_salary.find(".detail-early_1").text(response.salary.early_1);
                                detail_salary.find(".detail-deduction_early_1").text(response.fines[2].deduction_detail);
                                detail_salary.find(".detail-deduction_salary_early_1").text(response.salary.deduction_early_one_detail );
                                detail_salary.find(".detail-early_2").text(response.salary.early_2);
                                detail_salary.find(".detail-deduction_early_2").text(response.fines[3].deduction_detail);
                                detail_salary.find(".detail-deduction_salary_early_2").text(response.salary.deduction_early_two_detail );
                                detail_salary.find(".detail-miss").text(response.salary.miss);
                                detail_salary.find(".detail-deduction_miss").text(response.fines[4].deduction_detail);
                                detail_salary.find(".detail-deduction_salary_miss").text(response.salary.deduction_miss_detail );
                                detail_salary.find(".detail-salary").text(response.salary.salary_money);
                                
                            }
                        });
                    });
                }

        });
    </script>
@endpush
