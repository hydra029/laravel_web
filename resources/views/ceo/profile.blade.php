@extends('layout.master')
@include('ceo.menu')
@push('css')
	<link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
	<style>
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


        .image-upload > input {
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

	<div class="div-profile-success  ">

		<input name="action" onclick="history.back()" type="submit" value="back"
		       class="btn-warning btn-back rounded-pill "/>

		<button class="btn-primary btn-update rounded-pill float-right " type="button">
			Edit
		</button>
		<button class="btn-primary btn-close-update rounded-pill float-right d-none" type="button">
			Close
		</button>
		<br>
		<form action="" id="form-update" method="post" enctype="multipart/form-data">
			@csrf
			<div class="profile-card col-12 table-profile-success">
				<div class="profile-card-img float-left ">
					<div class="image-upload">
						<label class="text-center">
							@if($data->avatar == null )
								<img class="avatar-alter-add-null"
								     src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
							@else
								<img class="avatar-alter-add" src="{{ asset('') }}img/{{$data->avatar}}" width="100%">
							@endif
						</label>
					</div>
				</div>
				<div class="profile-card-info float-left">
					<div class="profile-card-info-basic">
						<table class="table ">
							<tr>
								<td class="col-3">Name:</td>
								<td>
									<span class="name-profile-success">{{$data->full_name}}</span>
								</td>
							</tr>
							<tr>
								<td>Gender:</td>
								<td>
									<span class="gender-profile-success">{{$data->gender_name}}</span>
								</td>
							</tr>
							<tr>
								<td>Date of birth:</td>
								<td>
									<span class="dob-profile-success">{{$data->date_of_birth}}</span>
								</td>
							</tr>
							<tr>
								<td>Address:</td>
								<td>
									<span class="address-profile-success">{{$data->address}}</span>
								</td>
							</tr>
							<tr>
								<td>Phone number</td>
								<td>
									<span class="phone-profile-success">{{$data->phone}}</span>
								</td>
							</tr>
							<tr>
								<td>Email:</td>
								<td>
									<span class="email-profile-success">{{$data->email}}</span>
								</td>
							</tr>
							@if(session('level') != 4)
								<tr>
									<td>
										<span class="dept-profile-success"></span>
									</td>
									<td>
										<span class="role-profile-success"></span>
									</td>
								</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
			<div class="profile-card col-12 table-profile-update d-none">
				<div class="profile-card-img float-left ">
					<div class="image-upload">
						<label for="file-input" class="text-center">
							@if($data->avatar == null )
								<img class="avatar-alter-add-null"
								     src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
							@else
								<img class="avatar-alter-add" src="{{ asset('') }}img/{{$data->avatar}}" width="100%">
							@endif
							<span>Click here to chage avatar</span>
						</label>
						<input id="file-input" type="file" name="avatar"/>
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
									                                                             name="fname"
									                                                             class="form-control inp-fname"
									                                                             placeholder="First Name"
									                                                             value="{{$data->fname}} "
									                                                             required>
								</td>
								<td>
									Last Name:
									<br>
									<span class="error-message-lname text-danger"> </span><input type="text"
									                                                             name="lname"
									                                                             class="form-control inp-lname "
									                                                             placeholder="Last Name"
									                                                             value="{{$data->lname}}"
									                                                             required>
								</td>
							</tr>
							<tr>
								<td>
									Gender:
								</td>
								<td>
									<input type="radio" name="gender" value="1" class="inp-gender"
									       @if($data->gender == 1)
										       checked
											@endif
									> Male
									<span> / </span>
									<input type="radio" name="gender" value="0" class="inp-gender"
									       @if($data->gender == 0)
										       checked
											@endif
									> Female
									<span class="error-message-gender text-danger "> </span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Date of birth:
									<br>
									<span class="error-message-dob text-danger"> </span> <input type="date"
									                                                            name="dob"
									                                                            class="form-control inp-dob"
									                                                            style="width: 100%; display: inline;"
									                                                            required
									                                                            value="{{$data->date_of_birth}}"
									                                                            placeholder="Date of birth">
								</td>
								<td></td>
							</tr>
							<tr>
								<td>
									City:
									<br>
									<span class="error-message-city text-danger"> </span><select name="city"
									                                                             id=""
									                                                             class="form-control select-city"></select>
								</td>
								<td>
									District:
									<br>
									<span class="error-message-district text-danger"> </span><select name="district"
									                                                                 id=""
									                                                                 class="select-district form-control"></select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Number phone:
									<br>
									<span class="error-message-phone text-danger"> </span> <input type="number"
									                                                              name="phone"
									                                                              placeholder="Number phone"
									                                                              class="form-control inp-phone"
									                                                              value="{{ $data->phone }}"
									                                                              required>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Email:
									<br>
									<span class="error-message-email text-danger"> </span><input type="email"
									                                                             name="email"
									                                                             value="{{ $data->email }}"
									                                                             placeholder="Email"
									                                                             class="form-control inp-email"
									                                                             required>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Password:
									<span toggle="#password-field"
									      class="fa fa-fw fa-eye field_icon toggle-password"></span>
									<span class="error-message-password text-danger"> </span> <input type="password"
									                                                                 name="password"
									                                                                 value=""
									                                                                 placeholder="Password"
									                                                                 class="form-control inp-password">
								</td>
							</tr>
							@if(session('level') != 4)
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
										<select id="" name="role_id"
										        class="form-control inp-role_id select-role"></select>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<button class="btn btn-success">Submit</button>
									</td>
								</tr>
							@endif
						</table>
					</div>
				</div>
			</div>
		</form>

	</div>
@endsection
@push('js')
	<script src="{{ asset('js/main.min.js' )}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script>
        $(document).ready(async function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('.select-city').select2();
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities   = await response.json();
            $.each(cities, function (index, each) {
                $('.select-city').append(
                    `<option value='${each.code}' data-path='${each.file_path}'>${index}</option>`);
            });
            $('.select-city').change(function () {
                loadDistrict();
            })
            loadDistrict();
            $('.select-district').select2();

            async function loadDistrict() {
                $('.select-district').empty();
                const path      = $(".select-city option:selected").data('path');
                const response  = await fetch('{{ asset('locations/') }}' + path);
                const districts = await response.json();
                $.each(districts.district, function (index, each) {
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
            $(".select-department").change(function () {
                var dept_id = $(this).val();
                select_role(dept_id);
            });

            function select_role(dept_id) {
                $(".select-role").empty();
                $.ajax({
                    type    : "post",
                    url     : "{{ route('ceo.select_role') }}",
                    data    : {
                        dept_id: dept_id
                    },
                    dataType: "json",
                    success : function (response) {
                        $.each(response, function (index, value) {
                            $(".select-role").append($('<option value="' + value.id + '">' +
                                value.name + '</option>'))
                        })
                    }
                });
            }

            $('.btn-update').click(function () {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').removeClass('d-none');
                $('.table-profile-success').addClass('d-none');
                $('.btn-close-update').removeClass('d-none');

            });
            $('.btn-close-update').click(function () {
                $('.title-name').text('');
                $(this).addClass('d-none');
                $('.table-profile-update').addClass('d-none');
                $('.table-profile-success').removeClass('d-none');
                $('.btn-update').removeClass('d-none');
            });

            $('#form-update').submit(function (e) {
                e.preventDefault();
                var formUpdate = $(this);
                $.ajax({
                    type       : "post",
                    url        : "{{ route('ceo.update_emp') }}",
                    dataType   : 'json',
                    async      : false,
                    cache      : false,
                    contentType: false,
                    enctype    : 'multipart/form-data',
                    data       : formUpdate.serialize(),
                    success    : function (response) {
                        console.log(response);
                    }
                });
            })

            $('.toggle-password').click(function () {
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
