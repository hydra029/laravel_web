@extends('layout.master')
@include('ceo.menu')

@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .div-form-create table tr td {
            border: 0;
        }

        /* @property --rotate {
                            syntax: "<angle>";
                            initial-value: 132deg;
                            inherits: false;
                            } */
        :root {
            --card-height: 65vh;
            --card-width: calc(var(--card-height) / 1.5);
        }

        .choose-card {
            width: var(--card-width);
            height: var(--card-height);
            padding: 3px;
            margin: 3%;
            position: relative;
            border-radius: 6px;
            justify-content: center;
            align-items: center;
            text-align: center;
            display: flex;
            font-size: 1.5em;
            cursor: pointer;
            font-family: cursive;
        }



        .image-upload>input {
            display: none;
        }

        .profile-card-img {
            width: 30%;
            height: 100%;
        }

        .profile-card-info {
            width: 70%;
            height: 100%;
        }

        .profile-card-info-basic {
            height: 75%;
        }

        .profile-card-roles {
            height: 25%;
        }
    </style>
@endpush
@section('content')
    <div class="choose-card-add d-flex p-2">
        <div class="choose-card float-left" style="background-color: rgb(88 199 250 / 100%)" data-id="1">
            <i class="fa-solid fa-circle-plus"></i>
            <span> Add employee</span>
        </div>
        <div class="choose-card float-left" style="background-color: rgb(188 109 250 / 100%)" data-id="2">
            <i class="fa-solid fa-circle-plus"></i>
            <span> Add accoutant </span>
        </div>
        <div class="choose-card float-left" style="background-color: rgb(188 199 100 / 100%)" data-id="3">
            <i class="fa-solid fa-circle-plus"></i>
            <span> Add manager</span>
        </div>
    </div>

    {{-- form add --}}
    <div class="div-form-create d-none ">
        <button class="btn-warning btn-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>
        <label for="import-csv" class="btn btn-info float-right">
            Import CSV
        </label>
        <input type="file" name="import_csv" id="import-csv" class="d-none">
        <form action="" id="form-create" method="post"  enctype="multipart/form-data">
            @csrf
            <div class="profile-card col-12">
                <div class="profile-card-img float-left ">
                    <div class="image-upload">
                        <label for="avatar-input" class="text-center">
                            <img id="avatar_null" src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                            <img id="output" width="100%"/>
                            <span>Click here to chage avatar</span>
                        </label>
                        <input type="file" name="avatar" accept="image/*" id="avatar-input" >
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
                                        id="" class="form-control select-city"></select>
                                </td>
                                <td>
                                    District:
                                    <br>
                                    <span class="error-message-district text-danger"> </span><select name="district"
                                        id="" class="form-control select-district"></select>
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
                                        name="email" value="" placeholder="Email" class="form-control inp-email">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    Password:
                                <span toggle="#password-field" class="fa fa-fw fa-eye field_icon toggle-password"></span>
                                    <span class="error-message-password text-danger"> </span> <input type="password"
                                        name="password" value="" placeholder="Password"
                                        class="form-control inp-password" id="pass_log_id" >
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="error-message-dept_id text-danger"> </span>
                                    <span>department</span>
                                    <span class="error-message-dept_id text-danger"> </span>
                                    <select id="" name="dept_id" class="select-department form-control inp-dept_id">
                                        @foreach ($dept as $each)
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span class="error-message-role_id text-danger"> </span>
                                    <span>role</span>
                                    <span class="error-message-role_id text-danger"> </span>
                                    <select id="" name="role_id" class="select-role form-control inp-role_id"></select>
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

    {{-- profile-success --}}
    <div class="div-profile-success d-none ">
        <button class="btn-warning btn-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <button class="btn-primary btn-update rounded-pill float-right " type="button">
            Edit
        </button>
        <button class="btn-primary btn-close-update rounded-pill float-right d-none" type="button">
            Close
        </button>
        <br>
        <form action="" id="form-update" method="post"  enctype="multipart/form-data">
            @csrf
            <div class="profile-card col-12 table-profile-success">
                <div class="profile-card-img float-left ">
                    <div class="image-upload">
                        <label  class="text-center">
                            <img class="avatar-alter-add-null" src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                            <img class="avatar-alter-add"  width="100%">
                        </label>
                    </div>
                </div>
                <div class="profile-card-info float-left">
                    <div class="profile-card-info-basic">
                        <table class="table ">
                            <tr>
                                <td class="col-3">Name: </td>
                                <td>
                                    <span class="name-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Gender: </td>
                                <td>
                                    <span class="gender-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Date of birth: </td>
                                <td>
                                    <span class="dob-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Address: </td>
                                <td>
                                    <span class="address-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td>
                                    <span class="phone-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>Email: </td>
                                <td>
                                    <span class="email-profile-success"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="dept-profile-success"></span>
                                </td>
                                <td>
                                    <span class="role-profile-success"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="profile-card col-12 table-profile-update d-none">
                <div class="profile-card-img float-left ">
                    <div class="image-upload">
                        <label for="file-input" class="text-center">
                            <img class="avatar-alter-add-null" src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                            <img class="avatar-alter-add"  width="100%">
                            <span>Click here to chage avatar</span>
                        </label>
                        <input id="file-input" type="file" name="avatar" />
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
                                        name="dob"   class="form-control inp-dob"
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
                                        id="" class="form-control select-city"></select>
                                </td>
                                <td>
                                    District:
                                    <br>
                                    <span class="error-message-district text-danger"> </span><select name="district"
                                        id="" class="select-district form-control"></select>
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
                                    <span class="error-message-password text-danger"> </span> <input type="password"
                                        name="password" value="" placeholder="Password"
                                        class="form-control inp-password">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>department</span>
                                    <span class="error-message-dept_id text-danger"> </span>
                                    <select id="" name="dept_id" class="form-control select-department inp-dept_id">
                                        @foreach ($dept as $each)
                                            <option value="{{ $each->id }}">{{ $each->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <span>role</span>
                                    <span class="error-message-role_id text-danger"> </span>
                                    <select id="" name="role_id" class="form-control inp-role_id select-role"></select>
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
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>,
    <script type="text/javascript">
        $(document).ready(async function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.choose-card').click(function() {
                var choose = $(this).data('id');
                $('.choose-card').addClass('d-none');
                $('.div-form-create').removeClass('d-none');
                create(choose);
            });

            $('.btn-back').click(function() {
                $('.title-name').text('');
                $('.choose-card').removeClass('d-none');
                $('.div-form-create').addClass('d-none');
                $('.div-profile-success').addClass('d-none');
                $("#avatar_null").removeClass('d-none');
                $("#output").addClass('d-none');
            });
            $('.btn-update').click(function() {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').removeClass('d-none');
                $('.table-profile-success').addClass('d-none');
                $('.btn-close-update').removeClass('d-none');
            });
            $('.btn-close-update').click(function() {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').addClass('d-none');
                $('.table-profile-success').removeClass('d-none');
                $('.btn-update').removeClass('d-none');
            });

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
            $('#avatar-input').change(function(event) {
                $('#avatar_null').addClass('d-none');
                $("#output").removeClass('d-none');
                var output = document.getElementById('output');
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
                }
            })

            function create(choose) {
                console.log(choose);
                // $('#avatar-input').change(function(event) {
                //     const { avatar } = event.target;
                // });
                var url, urlImport;
                switch(choose) {
                            case 1:
                                url =  "{{ route('ceo.store_emp') }}";
                                urlImport =  "{{ route('ceo.import_employee') }}";
                                break;
                            case 2:
                                url = "{{ route('ceo.store_acct') }}";
                                urlImport =  "{{ route('ceo.import_acct') }}";
                                break;
                            case 3:
                                url = "{{ route('ceo.store_mgr') }}";
                                urlImport =  "{{ route('ceo.import_mgr') }}";
                                break;
                            }
                $('#import-csv').change(function(event) {
                    var formData = new FormData();
                    formData.append('file', $(this)[0].files[0]);


                    $.ajax({
                        type: "post",
                        url:urlImport,
                        data: formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        enctype: 'multipart/form-data',
                        processData: false,
                        success: function (response) {
                            $.toast({
                                heading: "Import CSV Success",
                                text: "Your CSV file has been successfully",
                                showHidetransition:'slide',
                                position: 'button-right',
                                icon: 'success',
                            })
                        }

                    });
                });
                $('#form-create').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData($(this)[0]);

                    console.log(choose);
                    $.ajax({
                        type: 'post',
                        url: url,
                        processData: false,
                        contentType: false,
                        data: formData,
                        dataType: "json",

                        success: function(response) {
                            $.notify('Add new success', 'success');
                            $('.div-form-create').addClass('d-none');
                            $('.div-profile-success').removeClass('d-none');
                            $('.div-profile-success').find('.name-profile-success').text(
                                response[1]['full_name']);
                            $('.div-profile-success').find('.gender-profile-success').text(
                                response[1]['gender_name']);
                            $('.div-profile-success').find('.dob-profile-success').text(
                                response[1]['date_of_birth']);
                            $('.div-profile-success').find('.address-profile-success').text(
                                response[1]['address']);
                            $('.div-profile-success').find('.phone-profile-success').text(
                                response[1]['phone']);
                            $('.div-profile-success').find('.email-profile-success').text(
                                response[1]['email']);
                            $('.div-profile-success').find('.dept-profile-success').text(
                                response[0][0]['departments']['name']);
                            $('.div-profile-success').find('.role-profile-success').text(
                                response[0][0]['name']);
                                if(response[1]['avatar'] != null) {
                                    $(".avatar-alter-add-null").addClass('d-none');
                                    $(".avatar-alter-add").attr('src',`{{ asset('')}}/img/${response[1]['avatar']}  `);
                                }

                            $('#form-create')[0].reset();
                            $('#form-create').find('select').prop('selectedIndex',0);
                            $('.div-profile-success').find('input[name="fname"]').val(response[1]['fname']);
                            $('.div-profile-success').find('input[name="lname"]').val(response[1]['lname']);
                            $('.div-profile-success').find('input[name="dob"]').val(response[1]['dob']);
                            $('.div-profile-success').find('input[name="phone"]').val(response[1]['phone']);
                            $('.div-profile-success').find('input[name="email"]').val(response[1]['email']);

                        },
                        error: function(xhr, textStatus, errorThrown) {
                            var err = JSON.parse(xhr.responseText);
                            $.each(err.errors, function(key, value) {
                                $(`.error-message-${key}`).text(value);
                            })
                        }
                    });
                });
            }



            $('.select-city').select2();
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities = await response.json();
            $.each(cities, function(index, each) {
                $('.select-city').append(
                    `<option value='${each.code}' data-path='${each.file_path}'>${index}</option>`);
            });
            $('.select-city').change(function() {
                loadDistrict();
            })
            loadDistrict();
            $('.select-district').select2();
                async function loadDistrict() {
                    $('.select-district').empty();
                    const path = $(".select-city option:selected").data('path');
                    const response = await fetch('{{ asset('locations/') }}' + path);
                    const districts = await response.json();
                    $.each(districts.district, function(index, each) {
                        if (each.pre === "Quận" || each.pre === "Huyện") {
                            $('.select-district').append(`
                                <option>
                                    ${each.name}
                                </option>`);
                        }
                    });
            }

            var dept_id = $(".select-department").val();
            select_role(dept_id);
            $(".select-department").change(function() {
                var dept_id = $(this).val();
                select_role(dept_id);
            });

            function select_role(dept_id) {
                $(".select-role").empty();
                $.ajax({
                    type: "post",
                    url: "{{ route('ceo.select_role') }}",
                    data: {
                        dept_id: dept_id
                    },
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(index, value) {
                            $(".select-role").append($('<option value="' + value.id + '">' +
                                value.name + '</option>'))
                        })
                    }
                });
            }
            $('.btn-update').click(function() {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').removeClass('d-none');
                $('.table-profile-success').addClass('d-none');
                $('.btn-close-update').removeClass('d-none');

            });
            $('.btn-close-update').click(function() {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').addClass('d-none');
                $('.table-profile-success').removeClass('d-none');
                $('.btn-update').removeClass('d-none');
            });

            $('#form-update').submit(function(e) {
                e.preventDefault();
                var formUpdate = $(this);
                $.ajax({
                    type: "post",
                    url: "{{ route('ceo.update_emp') }}",
                    dataType: 'json',
                    async: false,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    data: formUpdate.serialize(),
                    success: function(response) {
                        console.log(response);
                    }
                });
            })

            $('.toggle-password').click(function(){
                $(this).toggleClass("fa-eye fa-eye-slash");

                var input = $("#pass_log_id");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
}
            })
        });
    </script>
@endpush
