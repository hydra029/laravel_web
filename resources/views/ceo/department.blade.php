@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            a:hover {
                text-decoration: underline !important;
                cursor: pointer;
            }
            .profile-card .table td, .table th {
                padding: 0.35rem;
            }
            .add-dept {
                background-color: bisque;
            }

            .btn-add-pay-rate {
                margin-left: 48%;
                margin-top: 10px;
            }

            .profile-card {
                background-color: rgb(241, 243, 240);
                position: absolute;
                margin: 0;
                padding: 0;
                top: 100px;
                right: 10px;
                width: 500px;
                height: 250px;
                animation-name: show_file;
            }

            .profile-close{
                cursor: pointer;
                position: absolute;
                top: -10px;
            }

            .profile-card-img {
                width: 35%;
                height: 75%;
            }

            .profile-card-info {
                width: 65%;
                height: 75%;
            }
        </style>
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
    {{-- // department_employees --}}
    <div class="dept d-none">
        <button class="btn-warning btn-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>
        <div class="col-12 p-2 border border-1 border-light bg-dark">
            <table class=" text-white  w-100">
                <tr>
                    <td class="col-9">
                        <form id="form-change-dept" method="post">
                            <div class="w-40">
                                <span>Departments</span>

                            </div>
                            <input type="hidden" name="dept_id" class="dept-id">
                            <span class="dept-name-detail text-warning"></span>
                        </form>
                    </td>
                    <td class="col-3">
                        <span class="tittle-pay-rate">Manager</span>
                        <br>
                        <span class="manager-name-detail text-warning"></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 p-2 border border-1 border-light department_employees ">
        </div>
    </div>
    {{-- // department list table --}}
    <div class="dept-list">
        <button class="btn-success rounded-pill btn-add-dept " type="button">
            Add
            <span class="btn-label">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
        </button>
        <br>
        <div class="col-12 p-2 border border-1 border-light dept-list">
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th colspan="7">
                            <h4 class="text-white">Departments list</h4>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="text-primary">
                        <td class="col-1"><span>#</span></td>
                        <td><span>Name</span></td>
                        <td><a class="members-department">Members</a></td>
                        <td><span>Manager</span></td>
                        <td><span>Roles / Pay rate</span></td>
                        <td><span>Status</span></td>
                        <td> <span>Action</span></td>
                    </tr>
                    @foreach ($dept as $each)
                        <tr class="div-dept">
                            <td class="col-1">
                                <div>
                                    <span class="dept-id text-danger">{{ $each->id }}</span><span>.</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <form class="form-change-dept" method="post">
                                        <span class="dept-name ">{{ $each->name }}</span>
                                        <span class="change-dept float-right"><i
                                                class="fa-solid fa-pen-to-square"></i></span>
                                        <span class="exit-change-dept d-none"><i
                                                class="fa-solid fa-circle-xmark"></i></span>
                                        <br>
                                        <input type="hidden" name="dept_id" class="dept-id" value="{{ $each->id }}">
                                        <input type="text" name="name" value=" {{ $each->name }} "
                                            class="d-none inp-dept">
                                        <button class="btn-change-dept d-none ">
                                            <i class="fa-solid fa-pen-to-square"></i></button>
                                    </form>
                                </div>
                            </td>
                            <td>
                                <di>
                                    <a class="dept-members members-department ">{{ $each->members_count }} members</a>
                                </di>
                            </td>
                            <td>
                                <div>
                                    @if ($each->manager === null)
                                        <span>null</span>
                                    @else
                                        <span class="manager-id d-none">{{ $each->manager->id }}</span>
                                        <span class="manager-gender d-none">{{ $each->manager->gender_name }}</span>
                                        <span class="manager-dob d-none">{{ $each->manager->date_of_birth }}</span>
                                        <span class="manager-email d-none">{{ $each->manager->email }}</span>
                                        <span class="manager-role d-none">{{ $each->manager->role_id }}</span>
                                        <a class="manager-name ">{{ $each->manager->full_name }}</a>
                                    @endif

                                </div>
                            </td>
                            <td>
                                <div>
                                    <a class="roles-department ">{{ $each->roles_count }} roles</a>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="dept-status ">{{ $each->status }}</span>
                                </div>
                            </td>
                            <td>
                                <div>
                                </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- form add department --}}
    <div class="add-dept-div  d-none  ">
        <div class="add-dept col-6">
            <button class="btn-warning btn-form-back rounded-pill " type="button">
                <span class="btn-label">
                    <i class="fa-solid fa-circle-arrow-left"></i>
                </span>
                back
            </button>
            <br>
            <br>
            <form id="add-department" action="{{ route('ceo.department.store') }}" method="post"
                novalidate="novalidate">
                <div class="card-header card-header-icon" data-background-color="rose">
                    <i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
                    <span class=" card-title h2"> Add department</span>
                </div>
                <div class="card-content">
                    @csrf
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">
                            Name
                            <small class="text-danger">*</small>
                        </label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">
                            Status
                        </label>
                        <select class="form-control" name="status">
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="form-group label-floating is-empty">
                        <button class="btn-success btn-xm rounded-pill btn-add-department">Add</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- roles --}}
    <div class="dept-roles d-none">
        <button class="btn-warning btn-back-roles rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <div class="col-12 p-2 border border-1 border-light dept-name bg-dark">
            <table class=" text-white  w-100">
                <tr>
                    <td class="col-4">
                        <h4>Departments</h4>
                        <br>
                        <span class="text-warning dept-name-roles"></span>
                    </td>
                    <td class="col-8">

                    </td>
                </tr>
            </table>
        </div>
        <div class="col-12 p-2 border border-1 border-light pay-rate">
        </div>
        <div class="btn btn-add-pay-rate btn-success "><i class="fa-solid fa-circle-plus"></i> Add</div>
        <div class="div-inp-add-pay-rate"></div>
    </div>

    {{-- profile --}}

    <div class="profile-card col-6 d-none">
        <span class="profile-close float-left"	><i class="fa-solid fa-circle-xmark"></i></span>
        <div class="profile-card-img float-left ">
            <span><img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%"
                    alt="Logo"></span>
        </div>
        <div class="profile-card-info float-left">
            <table class="table">
                <tr>
                    <td class="col-5">Name:</td>
                    <td><span class="profile-card-name "></span></td>
                </tr>
                <tr>
                    <td>Gender:</td>
                    <td><span class="profile-card-gender"></span></td>
                </tr>
                <tr>
                    <td> Date of birth:</td>
                    <td><span class="profile-card-dob"></span></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><span class="profile-card-email"></span></td>
                </tr>
                <tr>
                    <td>Number phone:</td>
                    <td><span class="profile-card-number-phone"></span></td>
                </tr>
            </table>
        </div>
        <div class="profile-card-roles ">
            <table class="table">
                <tr>
                    <th>
                        <span>department</span>
                        <span class="profile-card-department"></span>
                    </th>
                    <th>
                        <span>role</span>
                        <span class="profile-card-role"></span>
                    </th>
                </tr>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    // searching by department
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // add department

            $('.btn-add-dept').click(function() {
                $('.title-name').text(' > Form add dept');
                $('.add-dept-div').removeClass('d-none');
                $('.dept-list').addClass('d-none');
            });
            $('.btn-back').click(function() {
                $('.title-name').text('');
                $('.dept').addClass('d-none');
                $('.dept-list').removeClass('d-none');
                $('.dept-name-detail').removeClass('d-none');
                $('.inp-dept').addClass('d-none');
                $('.btn-change-dept').addClass('d-none');
                $('.change-dept').removeClass('d-none');
                $('.exit-change-dept').addClass('d-none');
            });
            $('.btn-form-back').click(function() {
                $('.title-name').text('');
                $('.dept-list').removeClass('d-none');
                $('.add-dept-div').addClass('d-none');
            })
            $('.btn-back-roles').click(function() {
                $('.title-name').text('');
                $('.dept-list').removeClass('d-none');
                $('.dept-roles').addClass('d-none');
            })

            // show roles list
            var roles_list = [];
            $('.roles-department').click(function(event) {
                $('.title-name').text(' > Department roles');
                $('.dept-list').addClass('d-none');
                $('.dept-roles').removeClass('d-none');
                let dept_id = $(this).parents('tr').find('.dept-id').text();
                let pay_rate = $('.pay-rate');
                if (roles_list.indexOf(dept_id) == -1) {
                    roles_list.push(dept_id);
                    $.ajax({
                        url: '{{ route('ceo.pay_rate_api') }}',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            dept_id: dept_id
                        },
                        success: function(response) {

                            pay_rate.html('');
                            pay_rate.append(
                                '<table class="table table-striped table-centered table-sm table-bordered  student-table-index">' +
                                '<thead class="thead-dark">' +
                                '<tr>' +
                                '<th class=" col-1 ">#</th>' +
                                '<th class=" col-1 ">Roles</th>' +
                                '<th class=" col-1 text-center">Pay rate</th>' +
                                '<th class=" col-1 text-center">Change</th>' +
                                '</tr>' +
                                '</thead>')
                            $.each(response, function(index, value) {
                                pay_rate.append(
                                    '<tr>' +
                                    '<form id="form-payRate-change" method="post">' +
                                    '<td class=" col-1 text-danger">' +
                                    '<div class =" form-group ">' + (index + 1) +
                                    '.' + '</div>' +
                                    '</td>' +
                                    '<td class="col-1">' +
                                    '<div class="role-name  form-group">' +
                                    value.name +
                                    '</div>' +
                                    '<label class="role-name-inp d-none">' +
                                    '<input type="text" name="role_id" class="form-control " value="' +
                                    value.id + '">' +
                                    '</label>' +
                                    '</td>' +
                                    '<td class="col-1">' +
                                    '<div class="pay-rate text-center">' +
                                    value.pay_rate_money +
                                    '</div>' +
                                    '<label class="pay-rate-inp d-none">' +
                                    '<input type="text" name="pay_rate" class="form-control " value="' +
                                    value.pay_rate + '">' +
                                    '</label>' +
                                    '</td>' +
                                    '<td class="col-1 ">' +
                                    '<div align="center" class="">' +
                                    '<button type="button" class="btn btn-primary btn-change">' +
                                    'Change' +
                                    '</button>' +
                                    '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' +
                                    value.pay_rate + '" data-id ="' + value.id +
                                    '">' +
                                    'Save' +
                                    '</button>' +
                                    '</div>' +
                                    '</td>' +
                                    '</form>' +
                                    '</tr>' +
                                    '</table>')
                            });
                            change();
                        }
                    });
                } else {
                    change();
                }
            });

            function change() {
                $('.btn-change').click(function(event) {
                    console.log('change');
                    $(this).addClass('d-none');
                    $(this).parents('tr').find('.btn-save').removeClass('d-none');
                    $(this).parents('tr').find('.pay-rate-inp').removeClass('d-none');
                    $(this).parents('tr').find('.pay-rate').addClass('d-none');
                });
                $('.btn-save').click(function(event) {
                    let tr = $(this).parents('tr');
                    const pay_rate_regex = /^[0-9]{6,9}$/;
                    let data = tr.find('.pay-rate-inp').find('input[name="pay_rate"]').val();
                    let id = $(this).data('id');
                    console.log(data);
                    if (data.match(pay_rate_regex)) {
                        console.log('success');
                    }

                    $.ajax({
                        url: "{{ route('ceo.pay_rate_change') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            pay_rate: data,
                            id: id,
                        },
                        success: function(response) {
                            tr.find('.btn-change').removeClass('d-none');
                            tr.find('.btn-save').addClass('d-none');
                            tr.find('.pay-rate-inp').addClass('d-none');
                            tr.find('.pay-rate').removeClass('d-none');
                            tr.find('.pay-rate').text(response[0]["pay_rate_money"]);
                            $.notify('Action completed', 'success');
                        }
                    })

                });
            }

            // show the members list
            var dept_list = [];
            $('.members-department').click(function() {
                $('.title-name').text(' > Department members');
                $('.dept').removeClass('d-none');
                $('.dept-list').addClass('d-none');
                var dept_id = $(this).parents('tr').find('.dept-id').text();
                var dept_name = $(this).parents('tr').find('.dept-name').text();
                var manager_name = $(this).parents('tr').find('.manager-name').text();
                $('.dept-name-detail').text(dept_name);
                $('.manager-name-detail').text(manager_name);
                if (dept_list.indexOf(dept_id) == -1) {
                    dept_list.push(dept_id);

                    $.ajax({
                        url: "{{ route('ceo.department_employees') }}",
                        method: "POST",
                        datatype: 'json',
                        data: {
                            dept_id: dept_id
                        },
                        success: function(response) {
                            $('.department_employees').html('');
                            $('.department_employees').append(
                                '<table class="table table-striped table-bordere table-hover table-sm">' +
                                '<thead class="">' +
                                '<tr>' +
                                '<th class=" col-1 ">#</th>' +
                                '<th class=" col-1 ">Name</th>' +
                                '<th class=" col-1 ">Role</th>' +
                                '<th class=" col-1 ">Action</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                '<div class="col-12">'
                            );

                            $.each(response, function(index, value) {
                                $('.department_employees').append(
                                    '<tr>' +
                                    '<td class=" col-1 ">' +
                                    '<div class="form-group text-danger">' + (
                                        index + 1) + '.' + '</div>' +
                                    '</td>' +
                                    '<td class=" col-1 ">' +
                                    '<div class="form-group">' +
                                    '<a class="employee-name">' + value.full_name + '</a>' +
                                    '</div>' +
                                    '</td>' +
                                    '<td class=" col-1 ">' +
                                    '<div class="form-group">' + value.role_name +
                                    '</div>' +
                                    '</td>' +
                                    '<td class=" col-1 ">' +
                                    '<button class="btn btn-primary btn-sm employee_infor" data-id="' +
                                    value.id + '">Details</button>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                            $('.department_employees').append(
                                '</div>' +
                                '</tbody>' +
                                '</table>'
                            );
                            show_infor();
                        }
                    });
                } else {
                    show_infor();
                }
            });

            function show_infor() {
                $('.employee_infor').click(function() {
                    let employee_id = $(this).data('id');
                    console.log(employee_id);
                    $.ajax({
                        url: "{{ route('ceo.infomation') }}",
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            id: employee_id,
                        },
                        success: function(response) {
                            console.log(1);
                        }
                    })
                })
            }
            // change department
            $('.change-dept').click(function() {
                $(this).addClass('d-none');
                var dept_name = $(this).parents('tr').find('.dept-name').text();
                $(this).parents('tr').find('.dept-name').addClass('d-none');
                $(this).parents('tr').find('.inp-dept').removeClass('d-none');
                $(this).parents('tr').find('.inp-dept').val(dept_name);
                $(this).parents('tr').find('.btn-change-dept').removeClass('d-none');
                $(this).parents('tr').find('.exit-change-dept').removeClass('d-none');
            });
            $('.exit-change-dept').click(function() {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.dept-name').removeClass('d-none');
                $(this).parents('tr').find('.inp-dept').addClass('d-none');
                $(this).parents('tr').find('.btn-change-dept').addClass('d-none');
                $(this).parents('tr').find('.change-dept').removeClass('d-none');
            })

            $('.form-change-dept').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: "{{ route('ceo.department.update') }}",
                    method: "POST",
                    datatype: 'json',
                    data: form.serialize(),
                    success: function(response) {
                        let val = form.find('.inp-dept').val()
                        form.find('.inp-dept').addClass('d-none');
                        form.find('.btn-change-dept').addClass('d-none');
                        form.find('.change-dept').removeClass('d-none');
                        form.find('.exit-change-dept').addClass('d-none');
                        form.find('.dept-name-detail').text(val);
                        form.find('.dept-name').text(val);
                        form.find('.dept-name').removeClass('d-none');
                    }
                })

            });

            // views profile manager

            $('.manager-name').click(function(e) {
                // values: e.clientX, e.clientY, e.pageX, e.pageY
                // over
                var relativeYPosition = (e.pageY - this.offsetTop) - 250;

                $('.profile-card')[0].style.top = relativeYPosition + 'px';
                var id_manager = $(this).parents('tr').find('.manager-id').text();
                var name_manager = $(this).parents('tr').find('.manager-name').text();
                var gender_manager = $(this).parents('tr').find('.manager-gender').text();
                var dob_manager = $(this).parents('tr').find('.manager-dob').text();
                var email_manager = $(this).parents('tr').find('.manager-email').text();
                var id_role_manager = $(this).parents('tr').find('.manager-role').text();
                $('.profile-card').find('.profile-card-info').find('.profile-card-name').text(name_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-gender').text(
                    gender_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-dob').text(dob_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-email').text(
                    email_manager);
                $.ajax({
                    url: "{{ route('ceo.department.manager_role') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        role_id: id_role_manager,
                    },
                    success: function(response) {
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-role').text(response[0]['name']);
                    }
                })

                    $('.profile-card').removeClass('d-none');


            });
            $('.profile-close').click(function() {
                $('.profile-card').addClass('d-none');
            });
        });
    </script>
@endpush
