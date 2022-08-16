@extends('layout.master')
@include('accountants.menu')
@push('css')
    <link href="{{ asset('css/main.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    {{-- <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/dt-1.12.1/af-2.4.0/b-2.2.3/b-colvis-2.2.3/b-html5-2.2.3/b-print-2.2.3/date-1.1.2/fh-3.2.4/r-2.3.0/rg-1.2.0/sb-1.3.4/sp-2.0.2/datatables.min.css" />

    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" rel="stylesheet" type="text/css" id="light-style" />
    <link href="{{ asset('css/responsive.bootstrap4.css') }}" rel="stylesheet" type="text/css" id="light-style" /> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    {{-- <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
     --}}
    <style>

    </style>
@endpush
@section('content')
<div class="table-salary col-12">
    <div class="date w-100" >
        Month: <select name="month" id="select-month"></select>
        Year: <select name="year" id="select-year"></select>
         <input type="hidden" style="width: 1.5em" name="month" value="" readonly>
         <input type="hidden" style="width: 3em" name="year" value="" readonly>
        <span class="btn btn-primary float-right m-1 btn-approve" >Approve</span>
    </div>
    <table id="salary-table" class="table table-striped table-bordered w-100 table-sm text-center"  cellspacing="0" width="100%">
        <thead>
                <th class="th-sm">#</th>
                <th class="th-sm"></th>
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

    <div>
        <button class="btn btn-danger btn-sm btn-test float-right">Tạo bảng luơng</button>
    </div>
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
                            <th class="text-right"> <i class="fa-solid fa-pen btn-edit-salary text-warning" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i></th>
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
    {{-- <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('js/demo.datatable-init.js' )}}"></script> --}}
    {{-- <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/datatables.min.js"></script> --}}

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
                    var month = d.getMonth();
                    var year = d.getFullYear();
                    if (month == 1) {
                        month = 12;
                        year = year - 1;
                    }else {
                        month = month - 1;
                    }
                    
                        for (let i = year; i >= 2018; i--) {
                            $('#select-year').append(`<option value="${i}">${i}</option>`);
                        }
                        for (let i = month; i >= 1; i--) {
                            $('#select-month').append(`<option value="${i}">${i}</option>`);
                        }

                    $('.date input[name="month"]').val(month);
                    $('.date input[name="year"]').val(year);
                    
                })()

                var detail_salary = $(".table-show-salary-detail");
                var month =  $('.date input[name="month"]').val();
                var year =   $('.date input[name="year"]').val();
                $('#select-month').change(function (e) { 
                    month = $(this).val();
                    $("#salary-table tbody").empty();
                    getSalary(month, year);
                });
                $('#select-year').change(function (e) { 
                    year = $(this).val();
                    
                    if( $('#select-year').val() < (new Date()).getFullYear()){
                        month = 12;
                        $('#select-month').empty();
                        for (let i = month; i >= 1; i--) {
                            $('#select-month').append(`<option value="${i}">${i}</option>`);
                        }
                    }else{
                        month = (new Date()).getMonth() - 1;
                        $('#select-month').empty();
                        for (let i = month; i >= 1; i--) {
                            $('#select-month').append(`<option value="${i}">${i}</option>`);
                        }
                    }
                    $("#salary-table tbody").empty();
                    getSalary(month, year);
                });
                getSalary(month, year);

                function getSalary(month, year) {
                    $('#salary-pagination').empty();
                        
                    $.ajax({
                        type: "post",
                        url: "{{ route('accountants.get_salary') }}",
                        data: {
                            month: month,
                            year: year
                        },
                        dataType: "json",
                        success: function (response) {
                            $.each(response.data.data, function(k, v) {
                                /// do stuff
                                if (v.emp[0].avatar == null) {
                                    var img =
                                        `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="40px">`
                                } else {
                                    var img =
                                        `<img  src="{{ asset('') }}img/${v.emp[0].avatar} "  style=" border-radius:50% " width="40px"/>`
                                }
                                if (v.acct_id == null) {
                                    var approve =
                                    ` <input type="checkbox" name="approve" class="check_box" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"> `
                                } else {
                                    var approve =
                                        `<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                        width="16" height="16"
                                        viewBox="0 0 40 40"
                                        style=" fill:#000000;"><path fill="#bae0bd" d="M20,38.5C9.8,38.5,1.5,30.2,1.5,20S9.8,1.5,20,1.5S38.5,9.8,38.5,20S30.2,38.5,20,38.5z"></path><path fill="#5e9c76" d="M20,2c9.9,0,18,8.1,18,18s-8.1,18-18,18S2,29.9,2,20S10.1,2,20,2 M20,1C9.5,1,1,9.5,1,20s8.5,19,19,19	s19-8.5,19-19S30.5,1,20,1L20,1z"></path><path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="3" d="M11.2,20.1l5.8,5.8l13.2-13.2"></path></svg>`
                                }
                                $("#salary-table tbody").append($("<tr>")
                                    .append($("<td class='align-middle'>").append( k + 1 ))
                                    .append($("<td class='align-middle'>").append( img ))
                                    .append($("<td class='align-middle'>").append( v.emp[0].fname + ' ' + v.emp[0].lname ))
                                    .append($("<td class='align-middle'>").append( v.dept_name ))
                                    .append($("<td class='align-middle'>").append( v.role_name ))
                                    .append($("<td class='align-middle'>").append( v.work_day ))
                                    .append($("<td class='align-middle'>").append( v.pay_rate_money ))
                                    .append($("<td class='align-middle'>").append( v.bonus_salary_over_work_day ))
                                    .append($("<td class='align-middle'>").append( v.deduction_detail ))
                                    .append($("<td class='align-middle'>").append( v.salary_money ))
                                    .append($("<td class='align-middle'>").append( `
                                                <i class="fa-solid fa-eye btn-show-salary text-primary" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i>
                                        ` ))
                                    .append($("<td class='align-middle'>").append( approve ))
                                        );
                            });
                            showDetailSalary();
                            renderSalaryPagination(response.data.pagination);
                            changePage(month, year);
                        }
                    });
                }

                function showDetailSalary(){
                    $(".btn-show-salary").click(function() {
                        var id = $(this).data('id');
                        var dept_name = $(this).data('dept_name');
                        var role_name = $(this).data('role_name');
                        var month =  $('.date input[name="month"]').val();
                        var year =   $('.date input[name="year"]').val();
                        $.ajax({
                            type: "post",
                            url: "{{ route('accountants.salary_detail') }}",
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
                                detail_salary.find(".detail-bounus_salary_over_work_day").text(response.salary.bonus_salary_over_work_day);
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
                function changePage(month, year) {
                    $(document).on('click', '#salary-pagination > li > a', function(event) {
                        event.preventDefault();
                        var url = $(this).attr('href');
                        console.log(url);
                        $('#salary-table').find('tbody').empty();
                        $.ajax({
                            url: url,
                            method: "POST",
                            datatype: 'json',
                            data: {
                                month: month,
                                year: year,
                            },
                            success: function (response) {
                                $.each(response.data.data, function(k, v) {
                                    /// do stuff
                                    if (v.emp[0].avatar == null) {
                                        var img =
                                            `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="30px">`
                                    } else {
                                        var img =
                                            `<img  src="{{ asset('') }}img/${v.emp[0].avatar} "  style=" border-radius:50% " width="30px"/>`
                                    }
                                    if (v.sign == null) {
                                        var approve =
                                        ` <input type="checkbox" name="sign" class="check_box" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"> `
                                    } else {
                                        var approve =
                                            `<svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                                            width="16" height="16"
                                            viewBox="0 0 40 40"
                                            style=" fill:#000000;"><path fill="#bae0bd" d="M20,38.5C9.8,38.5,1.5,30.2,1.5,20S9.8,1.5,20,1.5S38.5,9.8,38.5,20S30.2,38.5,20,38.5z"></path><path fill="#5e9c76" d="M20,2c9.9,0,18,8.1,18,18s-8.1,18-18,18S2,29.9,2,20S10.1,2,20,2 M20,1C9.5,1,1,9.5,1,20s8.5,19,19,19	s19-8.5,19-19S30.5,1,20,1L20,1z"></path><path fill="none" stroke="#fff" stroke-miterlimit="10" stroke-width="3" d="M11.2,20.1l5.8,5.8l13.2-13.2"></path></svg>`
                                    }
                                    $("#salary-table tbody").append($("<tr>")
                                        .append($("<td class='align-middle'>").append( k + 1 ))
                                        .append($("<td class='align-middle'>").append( img ))
                                        .append($("<td class='align-middle'>").append( v.emp[0].fname + ' ' + v.emp[0].lname ))
                                        .append($("<td class='align-middle'>").append( v.dept_name ))
                                        .append($("<td class='align-middle'>").append( v.role_name ))
                                        .append($("<td class='align-middle'>").append( v.work_day ))
                                        .append($("<td class='align-middle'>").append( v.pay_rate_money ))
                                        .append($("<td class='align-middle'>").append( v.bonus_salary_over_work_day ))
                                        .append($("<td class='align-middle'>").append( v.deduction_detail ))
                                        .append($("<td class='align-middle'>").append( v.salary_money ))
                                        .append($("<td class='align-middle'>").append( `
                                                    <i class="fa-solid fa-eye btn-show-salary text-primary" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i>
                                            ` ))
                                        .append($("<td class='align-middle'>").append( approve ))
                                            );
                                });
                                $('#salary-pagination').empty();
                                showDetailSalary();
                                renderSalaryPagination(response.data.pagination);
                            }
                        });
                    });
                }
                function renderSalaryPagination(links) {
                    links.forEach(function(each) {
                        $('#salary-pagination').append($('<li>').attr('class',
                                `page-item ${each.active ? 'active' : ''}`)
                            .append(`<a class="page-link"
                                    href="${each.url}">
                                        ${each.label}
                                    </a>
                                `))
                    })
                }
                $(".btn-test").click(function () {
                    var data = 1 ;
                    $.ajax({
                        type: "post",
                        url: "{{ route('accountants.test') }}",
                        data: {
                            data: data
                        },
                        dataType: "json",
                        success: function (response) {
                            console.log(response);
                        }
                    });	
                });
                $(".btn-approve").click(function () {
                    var data = [];
                    $('input[name="approve"]:checked').each(function() {
                        let obj = new Object();
                        obj['id'] = $(this).data('id');
                        obj['dept_name'] = $(this).data('dept_name');
                        obj['role_name'] = $(this).data('role_name');
                        obj['month'] =  $('.date input[name="month"]').val();
                        obj['year'] =   $('.date input[name="year"]').val();
                        data.push(obj);
                    });
                    var data_to_send = JSON.stringify({ data });
                    if( data.lenght > 0 ){
                        $.ajax({
                            type: "post",
                            url: "{{ route('accountants.approve') }}",
                            data: data_to_send,
                            contentType: "application/json; charset=utf-8",
                            dataType: "json",
                            success: function (response) {
                                if(response.success == true){
                                    toastr.success(response.data.message);
                                    $.toast({
                                        heading: 'response.data.message',
                                        text: '',
                                        icon: 'success',
                                        showHideTransition: 'slide',
                                        allowToastClose: false,
                                        hideAfter: 3000,
                                        stack: 5,
                                        position: 'top-right',
                                        textAlign: 'left',
                                        loader: true,
                                    });
                                    setTimeout(function(){
                                        location.reload();
                                    }, 1000);
                                }else{
                                    $.toast({
                                        heading: 'response.data.message',
                                        text: '',
                                        icon: 'error',
                                        showHideTransition: 'slide',
                                        allowToastClose: false,
                                        hideAfter: 3000,
                                        stack: 5,
                                        position: 'top-right',
                                        textAlign: 'left',
                                        loader: true,
                                    });
                                }
                            }
                        });
                    }
                });

        });
    </script>
@endpush
