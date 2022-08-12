@extends('layout.master')
@include('ceo.menu')
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
.model-popup-div {
                background-color: rgba(0, 0, 0, 0.5);
                width: 100%;
                height: 100%;
                position: fixed;
                top: 0%;
                left: 0;
                z-index: 1100;
            }

            .model-popup {
                background-color: aliceblue;
                position: absolute;
                width: 50%;
                height: 80vh;
                top: 10%;
                left: 25%;
                opacity: 1;
                z-index: 1101;
                animation-name: popup;
                animation-duration: 1s;
            }

            @keyframes popup {
                0% {
                    opacity: 0;
                    transform: translateY(-100px);
                }

                100% {
                    opacity: 1;
                    transform: translateY(0px);
                }
            }

    </style>
@endpush
@section('content')
    <div class="date w-100" >
        Month <input type="text" style="width: 1.5em" name="month" value="" readonly>
        Year <input type="text" style="width: 3em" name="year" value="" readonly>
        <span class="btn btn-primary float-right m-1" >Approve</span>
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
                <th>Deduction</th>
                <th>Salary</th>
                <th>Action</th>
                <th>
                    <span>Approve</span>
                    <br>
                    <input type="checkbox" class="checkAll" name="approve_all">
                </th>
        </thead>
        <tbody>

        </tbody>
    </table>
    
    <div class=" model-popup-div d-none">
        <div class="popup-show-salary-detail d-none model-popup " >
            <div class="popup-show-salary-detail-content">
                <div class="card-header">
                    <span class="card-title h2">Salary Detail</span>
                    <button class="btn btn-danger btn-sm close-popup float-right">X</button>
                </div>
                <div class="popup-show-salary-detail-body">
                    <table class="table table-striped table-bordered" id="table-salary-detail" >
                        <thead>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
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
                $('.model-popup-div ').addClass('d-none');
                $('.model-popup').addClass('d-none');
                $('.model-popup').find('form')[0].reset();
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

                
                var month =  $('.date input[name="month"]').val();
                var year =   $('.date input[name="year"]').val();
                $.ajax({
                    type: "post",
                    url: "{{ route('ceo.salary_api') }}",
                    data: {
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
                            if (v.sign == null) {
                                var approve =
                                ` <input type="checkbox" name="approve[]" class="check_box" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"> `
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
                                .append($("<td class='align-middle'>").append( v.deduction_detail ))
                                .append($("<td class='align-middle'>").append( v.salary_money ))
                                .append($("<td class='align-middle'>").append( `
                                            <i class="fa-solid fa-eye btn-show-salary text-primary" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i>
                                            <i class="fa-solid fa-pen btn-edit-salary text-warning" data-id="${v.emp_id}" data-dept_name="${v.dept_name}" data-role_name="${v.role_name}"></i>
                                    ` ))
                                .append($("<td class='align-middle'>").append( approve ))
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
                            url: "{{ route('ceo.salary_detail') }}",
                            data: {
                                id: id,
                                dept_name : dept_name,
                                role_name : role_name,
                                month: month,
                                year: year
                            },
                            dataType: "json",
                            success: function (response) {
                                $('.model-popup-div ').removeClass('d-none');
                                $('.model-popup').removeClass('d-none');
                                
                            }
                        });
                    });
                }

        });
    </script>
@endpush
