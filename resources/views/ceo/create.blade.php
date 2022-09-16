@extends('layout.master')
@include('ceo.menu')
@push('css')
	<link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<style>
        .div-form-create table tr td {
            border: 0;
        }

        .image-upload {
            width: 20%;
            height: 100%;
        }

        .profile-card-info {
            width: 80%;
            height: 100%;
        }

        #information-form {
            width: 100%;
        }

        #div-profile {
            width: 100%;
            padding: 15px;
        }

        .btn {
            width: 15%;
            min-width: 100px;
        }

        label {
            padding-top: 10px;
        }

        .choose-card-add {
            width: 100%;
        }

        .choose-card {
            margin: 1%;
            height: 600px;
            width: 33% !important;
            padding: 0;
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
	</style>
@endpush
@section('content')
	<div class="choose-card-add d-flex">
		<div class="choose-card float-left" style="background-color: rgb(88 199 250 / 100%)" data-emp_type="1">
			<i class="fa-solid fa-circle-plus"></i>
			<span> Add employee</span>
		</div>
		<div class="choose-card float-left" style="background-color: rgb(188 109 250 / 100%)" data-emp_type="2">
			<i class="fa-solid fa-circle-plus"></i>
			<span> Add manager </span>
		</div>
		<div class="choose-card float-left" style="background-color: rgb(188 199 100 / 100%)" data-emp_type="3">
			<i class="fa-solid fa-circle-plus"></i>
			<span> Add accountant</span>
		</div>
	</div>
	<div id="div-profile" class="d-none">
		<form id="information-form" enctype="multipart/form-data">
			<div class="profile-card col-12 table-profile-update form-row">
				<div class="image-upload">
					<input type="hidden" name="type" id="type">
					<label for="avatar" class="text-center">
						@if($data->avatar === null )
							<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%" alt="">
						@else
							<img src="{{ asset('') }}uploads/{{$data->avatar}}" width="90%" alt="">
						@endif
						<span>Click here to change avatar</span>
					</label>
					<input id="avatar" type="file" accept="image/*" name="avatar" class="d-none">
				</div>
				<div class="profile-card-info float-left">
					<div class="form-row">
						<div class="form-group col-md-6">
							<span class="error-message-fname text-danger"></span>
							<label for="fname">
								First Name:
							</label>
							<input type="text" name="fname" id="fname" class="form-control inp-fname">
						</div>
						<div class="form-group col-md-6">
							<span class="error-message-lname text-danger"></span>
							<label for="lname">
								Last Name:
							</label>
							<input type="text" name="lname" id="lname" class="form-control inp-lname">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<span class="error-message-lname text-danger"></span>
							<label for="dob">
								Date of birth:
							</label>
							<input type="date" name="dob" id="dob" class="form-control inp-dob">
						</div>
						<div class="form-group col-md-4">
							<span class="error-message-gender text-danger"></span>
							<label for="gender">Gender</label>
							<select name="gender" id="gender" class="form-control">
								<option value="1" selected> Male</option>
								<option value="0"> Female</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<span class="error-message-phone text-danger"></span>
							<label for="phone">
								Number phone:
							</label>
							<input type="text" name="phone" id="phone" class="form-control inp-phone">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-city text-danger"></span>
							<div class="form-group" id="city-select">
								<label for="city">
									City:
								</label>
								<select name="city" id="city" class="form-control select-city"></select>
							</div>
						</div>
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-district text-danger"></span>
							<div class="form-group" id="district-select">
								<label for="district">
									District:
								</label>
								<select name="district" id="district"
								        class="form-control select-district"></select>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-department text-danger"></span>
							<div class="form-group" id="department-select">
								<label for="department">
									Department:
								</label>
								<select name="department" id="department"
								        class="form-control select-department"></select>
							</div>
						</div>
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-role text-danger"></span>
							<div class="form-group" id="role-select">
								<label for="role">
									Role:
								</label>
								<select name="role" id="role"
								        class="form-control select-role"></select>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<span class="error-message-email text-danger"></span>
							<label for="email">
								Email:
							</label>
							<input type="text" name="email" id="email" class="form-control inp-email">
						</div>
						<div class="form-group col-md-6">
							<span class="error-message-password text-danger"></span>
							<label for="password">
								Password:
							</label>
							<div class="input-group input-group-merge">
								<input type="password" name="password" id="password"
								       class="form-control inp-password">
								<div class="input-group-append" data-password="false">
									<div class="input-group-text">
										<span class="password-eye"></span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-row d-flex justify-content-center">
				<button class="btn btn-success">Submit</button>
				<button class="btn btn-danger ml-1">Cancel</button>
			</div>
		</form>
	</div>
@endsection
@push('js')
	<script src="{{ asset('js/main.min.js' )}}"></script>
	<script>
        $(document).ready(async function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
            let selectCity     = $('#city');
            let selectDistrict = $('#district');
            let avatar         = $('#avatar');
            let department     = $('#department');
            let role           = $('#role');
            let type           = $('#type');
            let profile        = $('#div-profile');
            let btnCancel      = $('.btn-danger');
            let btnSave        = $('.btn-success');
            let chooseCard     = $('.choose-card');

            chooseCard.click(function () {
                profile.prop('disabled', false);
                let emp_type = $(this).data('emp_type');
                type.val(emp_type);
                $.ajax({
                    type    : "post",
                    url     : "{{ route('ceo.get_department') }}",
                    dataType: "json",
                    data    : {type: emp_type},
                })
                    .done(function (response) {
                        let length = response.length;
                        department.data('type', type);
                        for (let i = 0; i < length; i++) {
                            department.append($("<option>")
                                .attr("value", response[i]['id'])
                                .text(response[i]['name'])
                            )
                        }
                        loadRoles(emp_type);
                    })
                chooseCard.addClass('d-none');
                profile.removeClass('d-none');
            })

            department.change(function () {
                let data = type.val();
                role.empty();
                loadRoles(data);
            })

            btnCancel.click(function (e) {
                e.preventDefault();
                profile.prop('disabled', true);
                chooseCard.removeClass('d-none');
                profile.addClass('d-none');
                department.empty();
                role.empty();
            })

            function loadRoles(type) {
                let dept_id = department.val();
                $.ajax({
                    type    : "post",
                    url     : "{{ route('ceo.get_role') }}",
                    dataType: "json",
                    data    : {
                        type   : type,
                        dept_id: dept_id
                    },
                })
                    .done(function (response) {
                        let length = response.length;
                        for (let i = 0; i < length; i++) {
                            role.append($("<option>")
                                .attr("value", response[i]['id'])
                                .text(response[i]['name'])
                            )
                        }
                    })
            }

            selectCity.select2();
            const response = await fetch('{{ asset('locations/Index.json') }}');
            const cities   = await response.json();
            $.each(cities, function (index, each) {
                selectCity.append(
                    `<option value='${each.code}' data-path='${each.file_path}'>${index}</option>`);
            });
            selectCity.change(function () {
                loadDistrict();
            })
            await loadDistrict();
            selectDistrict.select2();
            let keys     = Object.keys(cities);
            let city     = selectCity.data('city');
            let district = selectDistrict.data('district');

            if (city === 'Hà Nội') {
                $("#city").val('HN').trigger('change');
                setTimeout(function () {
                    $('#select2-district-container').text(district)
                }, 100);
            } else {
                keys.forEach(function (key) {
                    if (key === city) {
                        $("#city").val(cities[key]['code']).trigger('change');
                        setTimeout(function () {
                            $('#select2-district-container').text(district)
                        }, 100);
                    }
                });
            }

            async function loadDistrict() {
                selectDistrict.empty();
                const path      = $(".select-city option:selected").data('path');
                const response  = await fetch('{{ asset('locations/') }}' + path);
                const districts = await response.json();
                $.each(districts.district, function (index, each) {
                    if (each.pre === "Quận" || each.pre === "Huyện") {
                        selectDistrict.append(`
                            <option>
                            	${each.name}
                            </option>`);
                    }
                });
            }

            avatar.change(function () {
                $('img').attr('src', $(this).val());
            })

            btnSave.click(function (e) {
                e.preventDefault();
                let img = $('#avatar').val();
                if (!img) {
                    avatar.prop('disabled', true);
                }
                let formUpdate = $('#information-form');
                let data       = new FormData(formUpdate[0]);
                let city       = $('#select2-city-container').prop('title');
                let district   = $('#select2-district-container').prop('title').replace(/\s{2,}/g, '');
                let dept_id    = department.val();
                let role_id    = role.val();
                data.set('dept_id', dept_id);
                data.set('role_id', role_id);
                data.set('city', city);
                data.set('district', district);
                data.set('type', district);
                $.ajax({
                    type       : "post",
                    url        : "{{ route('ceo.save_emp') }}",
                    contentType: false,
                    processData: false,
                    data       : data,
                })
                    .done(function (response) {
                        chooseCard.addClass('d-none');
                        profile.removeClass('d-none');
                        if (response.success === true) {
                            notifySuccess(response.data.message);
                        } else {
                            notifyError(response.data.message);
                        }
                        btnCancel.click();
                    })
            })

            $('.toggle-password').click(function () {
                $(this).toggleClass("mdi-eye mdi-eye-off");
                let input = $("#password");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            })
        });
	</script>
@endpush
