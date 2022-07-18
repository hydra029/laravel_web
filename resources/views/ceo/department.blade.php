@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style type="text/css" href="{{asset('css/app.css')}}"></style>
        <style>
            .dept-list a:hover {
                text-decoration: underline !important;
                cursor: pointer;
            }

            i, img {
                cursor: pointer;
            }
            .profile-card .table td,
            .table th {
                padding: 0.35rem;
            }

            .add-dept {
                background-color: bisque;
            }

            .btn-add-roles {
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
                width: 600px;
                height: 300px;
                animation-name: show_file;
            }


            .profile-close {
                cursor: pointer;
                position: absolute;
                top: -10px;
            }

            .profile-card-img {
                width: 35%;
                height: 100%;
            }

            .profile-card-info {
                width: 65%;
                height: 100%;
            }

            .profile-card-info-basic {
                height: 75%;
            }

            .profile-card-roles {
                height: 25%;
            }
            #model-ask-delete{
                background-color: aliceblue;
                width: 300px;
                height: 200px;
                position: fixed;
                top: 10%;
                left: 50%;
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
    <div class="dept col-12 d-none">
        <button class="btn-warning btn-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>

        <div class="col-12 p-2 border border-1 border-light department_employees ">
            <table class="table table-bordere  " id="table-department-employees">
                <thead class="bg-light">
                    <tr>
                        <th class="col-1">#</th>
                        <th class="col-1"> Avatar</th>
                        <th class="col-2">Name</th>
                        <th class="col-4s">Gender</th>
                        <th class="col-2">Role</th>
                        <th class="col-2">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination float-right" id="employees-pagination">

                </ul>
            </nav>
        </div>
    </div>
    {{-- // department list table --}}
    <div class="dept-list col-12">
        <button class="btn-success rounded-pill btn-add-dept " type="button">
            Add
            <span class="btn-label">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
        </button>
        <br>
        <div class="col-12 p-2 border border-1 border-light dept-list">
            <table class="table table-striped table-striped table-bordered">

                <tr class="text-primary">
                    <td class="col-1"><span>#</span></td>
                    <td><span>Name</span></td>
                    <td><span>Members</span></td>
                    <td><span>Manager</span></td>
                    <td><span>Roles / Pay rate</span></td>
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
                                    <span class="change-dept float-right"><i class="fa-solid fa-pen-to-square"></i></span>
                                    <span class="exit-change-dept d-none"><i class="fa-solid fa-circle-xmark"></i></span>
                                    <br>
                                    <input type="hidden" name="dept_id" class="dept-id" value="{{ $each->id }}">
                                    <input type="text" name="name" value=" {{ $each->name }} "
                                        class="d-none inp-dept">
                                    <button class="btn-change-dept d-none "><i
                                            class="fa-solid fa-pen-to-square"></i></button>
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
                                    <span class="manager-phone d-none">{{ $each->manager->phone }}</span>
                                    <span class="manager-address d-none">{{ $each->manager->address }}</span>
                                    <span class="manager-role d-none">{{ $each->manager->role_id }}</span>
                                    <span class="manager-avatar d-none">{{ $each->manager->avatar }}</span>
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
                            </div>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{-- form add department --}}
    <div class="add-dept-div col-12 d-none  ">
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
    <div class="dept-roles col-12 d-none">
        <button class="btn-warning btn-back-roles rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>

        <div class="col-12 p-2 border border-1 border-light pay-rate">

            <table class="table table-striped table-bordered " id="table-pay-rate">
                <thead>
                    <th class="col-2">#</th>
                    <th class="col-4">Roles</th>
                    <th class="col-4">Pay rate</th>
                    <th class="col-2">Action</th>
                </thead>
                <tbody></tbody>
            </table>
            <nav aria-label="Page navigation example">
                <ul class="pagination float-right" id="roles-pagination">

                </ul>
            </nav>
        </div>
        <div class="btn btn-add-roles btn-success "><i class="fa-solid fa-circle-plus"></i> Add</div>
        <div class="div-inp-add-roles d-none col-8">
            <form class="form-add-roles" action="" method="post">
                @csrf
                <table class="table">
                    <tr>
                        <td>
                            <span>Name: </span>
                            <input type="text" name="name" class="inp-role-name">
                            <input type="hidden" name="dept_id" class="inp-dept-role-id">
                        </td>
                        <td>
                            <span>Pay rate: </span>
                            <input type="text" name="pay_rate" class="inp-role-pay_rate">
                        </td>
                        <td>
                            <button type="submit" name="" class="btn btn-primary btn-save-add-role">Save</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    {{-- profile --}}

    <div class="profile-card col-6 d-none">
        <span class="profile-close float-left"><i class="fa-solid fa-circle-xmark"></i></span>
        <div class="profile-card-img float-left ">

            <span><img src="" width="100%" alt="Logo"></span>
        </div>
        <div class="profile-card-info float-left">
            <div class="profile-card-info-basic">
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
                        <td>Date of birth:</td>
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
                    <tr>
                        <td>Address:</td>
                        <td><span class="profile-card-address"></span></td>
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
    </div>
    {{-- edit profile --}}
    <div class="div-form-update-employee d-none ">
        <button class="btn-warning btn-back-form-update-employee rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>
        <form action="" method="post" id="form-update-employees">
            @csrf
            <div class="profile-card-edit col-12">
                <div class="profile-card-img float-left ">
                    <div class="image-upload">
                        <label for="file-input" class="text-center">
                            <img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                            <span>Click here to chage avatar</span>
                        </label>

                        <input id="file-input" type="file" class="d-none" />
                    </div>
                </div>
                <div class="profile-card-info float-left">
                    <div class="profile-card-info-basic">
                        <table class="table">
                            <tr>
                                <td class="col-6">
                                    First Name:
                                    <br>
                                    <span class="error-message-fname text-danger"> </span><input type="text"
                                        name="fname" class="form-control inp-fname" placeholder="First Name">
                                </td>
                                <td>
                                    Last Name:
                                    <br>
                                    <span class="error-message-lname text-danger"> </span><input type="text"
                                        name="lname" class="form-control inp-lname " placeholder="Last Name">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Gender:
                                </td>
                                <td>
                                    <input type="radio" name="gender" value="1" class="inp-gender"> Male
                                    <span> / </span>
                                    <input type="radio" name="gender" value="0" class="inp-gender"> Female
                                    <span class="error-message-gender text-danger "> </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Date of birth:
                                    <br>
                                    <span class="error-message-dob text-danger"> </span> <input type="date"
                                        name="dob" id="date" class="form-control inp-dob"
                                        style="width: 100%; display: inline;" required value=""
                                        placeholder="Date of birth">
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>
                                    City:
                                    <br>
                                    <span class="error-message-city text-danger"> </span><select name="city"
                                        id="select-city" class="form-control"></select>
                                </td>
                                <td>
                                    District:
                                    <br>
                                    <span class="error-message-district text-danger"> </span><select name="district"
                                        id="select-district" class="form-control"></select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Number phone:
                                    <br>
                                    <span class="error-message-phone text-danger"> </span> <input type="number"
                                        name="phone" value="" placeholder="Number phone"
                                        class="form-control inp-phone">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Email:
                                    <br>
                                    <span class="error-message-email text-danger"> </span><input type="email"
                                        name="email" value="" placeholder="Email"
                                        class="form-control inp-email">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Password:
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                    <br>
                                    <span class="error-message-password text-danger"> </span> <input type="password"
                                        name="password" value="" placeholder="Password"
                                        class="form-control inp-password">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>department</span>
                                    <span class="error-message-dept_id text-danger"> </span>
                                    <select id="select-department" name="dept_id" class="form-control inp-dept_id">
                                        @foreach ($dept as $each)
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span>role</span>
                                    <span class="error-message-role_id text-danger"> </span>
                                    <select id="select-role" name="role_id" class="form-control inp-role_id"></select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-success">Submit</button>
                                </td>
                            </tr>
                        </table>
                    </div>

                </div>
            </div>
    </form>
</div>
<!-- Modal -->
<div id="model-ask-delete" class="d-none">
        <table>
            <tr>
                <td colspan="2" align="center" >
                    <h2>
                        Bạn có chắc chắn muốn xóa không?
                    </h2>
                </td>

            </tr>
            <tr>
                <td align="center">
                    <button class="btn btn-danger btn-close-delete">No</button>
                </td>
                <td align="center">
                    <button class="btn btn-success btn-success-delete">Yes</button>
                </td>
            </tr>
        </table>
</div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(async function() {
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
                $('#employees-pagination').empty();
                $('#table-department-employees').find('tbody').empty();
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
                $('#table-pay-rate').find('tbody').empty();
                $('.title-name').text(' > Department roles');
                $('.dept-list').addClass('d-none');
                $('.dept-roles').removeClass('d-none');
                let dept_id = $(this).parents('tr').find('.dept-id').text();
                let pay_rate = $('.pay-rate');
                let dept_name = $(this).parents('tr').find('.dept-name').text();
                $('.dept-name-roles').text(dept_name);
                $('.inp-dept-role-id').val(dept_id);
                $.ajax({
                    url: '{{ route('ceo.pay_rate_api') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function(response) {

                        $.each(response.data.data, function(index, value) {
                            $('#table-pay-rate').append($('<tr>')
                                .append($('<td>').append((index + 1) + '.'))
                                .append($('<td>').append(
                                    '<span class="role-name ">' + value
                                    .name + '</span>' +
                                    '<label class="role-name-inp d-none">' +
                                    '<input type="text" name="role_id" class="form-control " value="' +
                                    value.id + '">' +
                                    '</label>'))
                                .append($('<td>').append(
                                    '<span class="pay-rate ">' + value
                                    .pay_rate_money + '</span>' +
                                    '<label class="pay-rate-inp d-none">' +
                                    '<input type="text" name="pay_rate" class="form-control " value="' +
                                    value.pay_rate + '">' +
                                    '</label>'))
                                .append($('<td>').append(
                                    '<button type="button" class="btn btn-primary btn-change">' +
                                    'Change' + '</button>' +
                                    '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' +
                                    value.pay_rate + '" data-id ="' + value
                                    .id + '">' +
                                    'Save' + '</button>'))
                            )
                        });
                        renderRolesPagination(response.data.pagination);
                        change();
                        add_role();
                    }
                });
            });

            function renderRolesPagination(links) {
                $('#roles-pagination').empty();
                links.forEach(function(each) {
                    $('#pagination').append($('<li>').attr('class', 'page-item').append(`<a href="${each.url}" class="page-link ${each.active ? 'active' : ''} " >
                                ${each.label}
                            </a>`))

                });
            }

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
            $('.btn-add-roles').click(function() {
                $(this).addClass('d-none');
                $('.div-inp-add-roles').removeClass('d-none');
            });

            function add_role() {
                $('.form-add-roles').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    let pay_rate = $('.div-add-roles');
                    $.ajax({
                        url: "{{ route('ceo.pay_rate_store') }}",
                        method: "POST",
                        datatype: 'json',
                        data: form.serialize(),
                        success: function(response) {
                            $('#table-pay-rate').find('tbody').empty();
                            $.each(response, function(index, value) {
                                $('#table-pay-rate').append($('<tr>')
                                    .append($('<td>').append((index + 1) + '.'))
                                    .append($('<td>').append(
                                        '<span class="role-name ">' + value
                                        .name + '</span>' +
                                        '<label class="role-name-inp d-none">' +
                                        '<input type="text" name="role_id" class="form-control " value="' +
                                        value.id + '">' +
                                        '</label>'))
                                    .append($('<td>').append(
                                        '<span class="pay-rate">' + value
                                        .pay_rate_money + '</span>' +
                                        '<label class="pay-rate-inp d-none">' +
                                        '<input type="text" name="pay_rate" class="form-control " value="' +
                                        value.pay_rate + '">' +
                                        '</label>'))
                                    .append($('<td>').append(
                                        '<button type="button" class="btn btn-primary btn-change">' +
                                        'Change' + '</button>' +
                                        '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' +
                                        value.pay_rate + '" data-id ="' +
                                        value.id + '">' +
                                        'Save' + '</button>'))
                                )
                            });
                            change();
                        }
                    });
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
                $('#table-department-employees').find('tbody').empty();
                $.ajax({
                    url: "{{ route('ceo.department_employees') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function(response) {

                        $.each(response.data.data, function(index, value) {
                            $('#table-department-employees').append($(
                                    '<tr class="employee-row">')
                                .append($('<td class="align-middle">').append((
                                    index + 1) + '.'))
                                .append($('<td class="align-middle">').append(
                                    `<img  src="{{ asset('') }}img/${value.avatar} " class="rounded" width="100%" />`
                                    ))
                                .append($('<td class="align-middle">').append(
                                    value.full_name))
                                .append($('<td class="align-middle">').append(
                                    value.gender_name))
                                .append($('<td class="align-middle">').append(
                                    value.roles.name))
                                .append($('<td class="align-middle">').append(`
                                            <i class="fa-solid fa-eye btn-show-employee text-primary" data-id="${value.id}"></i>
                                            <i class="fa-solid fa-pen btn-edit-employee text-warning" data-id="${value.id}"></i>
                                            <i class="fa-solid fa-square-xmark btn-delete-employee text-danger"  data-id="${value.id}"></i>
                                        `))
                            )
                        });
                        console.log(response.data.pagination);
                        renderEmployeesPagination(response.data.pagination);
                        showEmployeesInfor();
                        changePage(dept_id);
                        update_emp();
                        delete_emp()
                    }
                });
            });

            function renderEmployeesPagination(links) {
                links.forEach(function(each) {
                    $('#employees-pagination').append($('<li>').attr('class',
                            `page-item ${each.active ? 'active' : ''}`)
                        .append(`<a class="page-link"
                                href="${each.url}">
                                    ${each.label}
                                </a>
                            `))
                })
            }

            function changePage(dept_id) {
                $(document).on('click', '#employees-pagination > li > a', function(event) {
                    event.preventDefault();
                    var url = $(this).attr('href');
                    console.log(url);
                    $('#table-department-employees').find('tbody').empty();
                    $.ajax({
                        url: url,
                        method: "POST",
                        datatype: 'json',
                        data: {
                            dept_id: dept_id
                        },
                        success: function(response) {

                            $.each(response.data.data, function(index, value) {
                                $('#table-department-employees').append($(
                                        `<tr class="employee-row" data-id="${value.id}">`
                                            )
                                    .append($('<td class="align-middle">')
                                        .append((index + 1) + '.'))
                                    .append($('<td class="align-middle">')
                                        .append(
                                            `<img  src="{{ asset('') }}img/${value.avatar}" class="rounded" width="100px" />`
                                            ))
                                    .append($('<td class="align-middle">')
                                        .append(value.full_name))
                                    .append($('<td class="align-middle">')
                                        .append(value.gender_name))
                                    .append($('<td class="align-middle">')
                                        .append(value.roles.name))
                                    .append($('<td class="align-middle">')
                                        .append(`
                                            <i class="fa-solid fa-eye btn-show-employee text-primary" data-id="${value.id}"></i>
                                            <i class="fa-solid fa-pen btn-edit-employee text-warning" data-id="${value.id}"></i>
                                            <i class="fa-solid fa-square-xmark btn-delete-employee text-danger" data-id="${value.id}"></i>
                                            `))
                                )
                            });
                            $('#employees-pagination').empty();
                            renderEmployeesPagination(response.data.pagination);
                            showEmployeesInfor();
                            update_emp();
                            delete_emp()
                        }
                    });
                });
            }

            function showEmployeesInfor() {
                $('.btn-show-employee').click(function(e) {
                    var id = $(this).data('id');
                    $.ajax({
                        type: "post",
                        url: "{{ route('ceo.employee_infor') }}",
                        data: {
                            id: id,
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            $('.profile-card').removeClass('d-none');
                            var relativeYPosition = (e.pageY - this.offsetTop) - 250;
                            $('.profile-card')[0].style.right = '240' + 'px';;
                            $('.profile-card')[0].style.top = relativeYPosition + 'px';
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-name').text(response[0].full_name);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-gender').text(response[0].gender);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-dob').text(response[0].date_of_birth);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-email').text(response[0].email);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-number-phone').text(response[0].phone);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-address').text(response[0].address);
                            if (response[0].avatar == null) {
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src',
                                        '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}'
                                        );
                            } else {
                                var src = '{{ asset('') }}';
                                var img = src + 'img/' + response[0].avatar;
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src', img);
                            }
                            $('.profile-card').find('.profile-card-roles').find(
                                '.profile-card-role').text(response[0].roles.name);
                            $('.profile-card').find('.profile-card-roles').find(
                                '.profile-card-department').text(response[0].departments
                                .name);
                        }
                    });
                });
            }

            function update_emp(){
                $('.btn-edit-employee').click(function(e) {
                    var id = $(this).data('id');
                    $('.div-form-update-employee').removeClass('d-none');
                    $('.dept').addClass('d-none');
                    $.ajax({
                        type: "post",
                        url: "{{ route('ceo.employee_infor') }}",
                        data: {
                            id: id,
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-fname').val(response[0].fname);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-dob').val(response[0].dob);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-lname').val(response[0].lname);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-phone').val(response[0].phone);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-email').val(response[0].email);

                            var formatDate = (date) => {
                            var day = getTwoDigits(date.getDate());
                            var month = getTwoDigits(date.getMonth() + 1); // add 1 since getMonth returns 0-11 for the months
                            var year = date.getFullYear();

                            return `${day}-${month}-${year}`;
                            }
                            var date = response[0].dob;
                            console.log(date);
                            $('.profile-card-edit').find('.profile-card-info').find('.inp-dob').value = formatDate(date);
                            if (response[0].avatar == null) {
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src',
                                        '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}'
                                        );
                            } else {
                                var src = '{{ asset('') }}';
                                var img = src + 'img/' + response[0].avatar;
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src', img);
                            }
                        }
                    });
                });
            }

            $('.btn-back-form-update-employee').click(function(e) {
                $('.dept').removeClass('d-none');
                $('.div-form-update-employee').addClass('d-none');
            })



           function delete_emp(){
                    $('.btn-delete-employee').click(function(){
                        var employee_delete = $(this);
                        let id = $(this).data('id');
                        console.log(id);

                        $("#model-ask-delete").removeClass('d-none');
                        $("#model-ask-delete").find(".btn-success-delete").data('id', id);
                    })
                    $(".btn-close-delete").click(function(){
                        $("#model-ask-delete").addClass('d-none');
                    })
                    $('.btn-success-delete').click(function(){
                        let id = $(this).data('id');
                        console.log(id);

                        $("#model-ask-delete").addClass('d-none');
                        $.ajax({
                            type: "delete",
                            url: `{{ route('ceo.delete_emp' ) }}`,
                            data: {
                                "id": id,
                            },
                            dataType: "json",
                            success: function (response) {
                                console.log(response);
                                $('#table-department-employees').find('.employee-row').matches(`[data-id="${id}"]`);
                                if ( $('#table-department-employees').find('.employee-row').matches(`[data-id="${id}"]`)    ){
                                            $(this).remove();
                                    }
                            }
                        });

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

            // form


            var array = [
                'fname',
                'lname',
                'gender',
                'dob',
                'phone',
                'email',
                'password',
            ];
            $.each(array, function(index, each) {
                let text = each;
                console.log(text);
                $(`.inp-${each}`).on("change paste keyup", function(text) {
                    $(`.error-message-${each}`).empty();
                });
            })

            $('#form-update-employees').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    type: 'post',
                    url: "{{ route('ceo.update_emp') }}",
                    data: form.serialize(),
                    dataType: 'json',
                    success: function(response) {
                        $.notify('success', 'edit success');
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-name').text(response[0].full_name);
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-gender').text(response[0].gender);
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-dob').text(response[0].date_of_birth);
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-email').text(response[0].email);
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-number-phone').text(response[0].phone);
                        $('.profile-card').find('.profile-card-info').find(
                            '.profile-card-address').text(response[0].address);
                        if (response[0].avatar == null) {
                            $('.profile-card').find('.profile-card-img').find('.image-upload').find('img').attr(
                                'src',
                                '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}'
                                );
                        } else {
                            var src = '{{ asset('') }}';
                            var img = src + 'img/' + response[0].avatar;
                            $('.profile-card').find('.profile-card-img').find('.image-upload').find('img').attr(
                                'src', img);
                        }
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-role').text(response[0].roles.name);
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-department').text(response[0].departments
                            .name);

                        $('#form-update-employees')[0].reset();

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var err = JSON.parse(xhr.responseText);
                        $.each(err.errors, function(key, value) {
                            $(`.error-message-${key}`).text(value);
                        })
                    }
                });
            });
            $('#select-city').select2();
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities = await response.json();
            $.each(cities, function(index, each) {
                $('#select-city').append(
                    `<option value='${each.code}' data-path='${each.file_path}'>${index}</option>`);
            });
            $('#select-city').change(function() {
                loadDistrict();
            })
            loadDistrict();
            $('#select-district').select2();
            async function loadDistrict() {
                $('#select-district').empty();
                const path = $("#select-city option:selected").data('path');
                const response = await fetch('{{ asset('locations/') }}' + path);
                const districts = await response.json();
                $.each(districts.district, function(index, each) {
                    if (each.pre === "Quận" || each.pre === "Huyện") {
                        $('#select-district').append(`
                            <option>
                                ${each.name}
                            </option>`);
                    }
                });
            }

            var dept_id = $("#select-department").val();
            select_role(dept_id);
            $("#select-department").change(function() {
                var dept_id = $(this).val();
                select_role(dept_id);
            });

            function select_role(dept_id) {
                $("#select-role").empty();
                $.ajax({
                    type: "post",
                    url: "{{ route('ceo.select_role') }}",
                    data: {
                        dept_id: dept_id
                    },
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(index, value) {
                            $("#select-role").append($('<option value="' + value.id + '">' +
                                value.name + '</option>'))
                        })
                    }
                });
            }

            // views profile manager

            $('.manager-name').click(function(e) {
                // values: e.clientX, e.clientY, e.pageX, e.pageY
                // over
                var relativeYPosition = (e.pageY - this.offsetTop) - 250;
                $('.profile-card')[0].style.right = '0' + 'px';;
                $('.profile-card')[0].style.top = relativeYPosition + 'px';
                var id_manager = $(this).parents('tr').find('.manager-id').text();
                var name_manager = $(this).parents('tr').find('.manager-name').text();
                var gender_manager = $(this).parents('tr').find('.manager-gender').text();
                var dob_manager = $(this).parents('tr').find('.manager-dob').text();
                var email_manager = $(this).parents('tr').find('.manager-email').text();
                var phone_manager = $(this).parents('tr').find('.manager-phone').text();
                var address_manager = $(this).parents('tr').find('.manager-address').text();
                var id_role_manager = $(this).parents('tr').find('.manager-role').text();
                var avatar_manager = $(this).parents('tr').find('.manager-avatar').text();
                $('.profile-card').find('.profile-card-info').find('.profile-card-name').text(
                    name_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-gender').text(
                    gender_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-dob').text(
                    dob_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-email').text(
                    email_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-number-phone').text(
                    phone_manager);
                $('.profile-card').find('.profile-card-info').find('.profile-card-address').text(
                    address_manager);
                if (avatar_manager === '') {
                    $('.profile-card').find('.profile-card-img').find('img').attr('src',
                        '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}');
                } else {
                    var src = '{{ asset('') }}';
                    var img = src + 'img/' + avatar_manager;
                    $('.profile-card').find('.profile-card-img').find('img').attr('src', img);
                }
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
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-department').text();
                    }
                })

                $('.profile-card').removeClass('d-none');


            });
            $('.profile-close').click(function() {
                $('.profile-card').addClass('d-none');
            });$('.toggle-password').click(function(){
                $(this).toggleClass("fa-eye fa-eye-slash");

                var input = $(".inp-password");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            })
        });
    </script>
@endpush
