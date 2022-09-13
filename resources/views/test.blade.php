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

        .form-control[readonly], .disabled, .select2-selection {
            background-color: white !important;
        }

        .na {
            cursor: default;
        }
	</style>
@endpush
@section('content')
	<div id="div-profile">
		<form id="information-form" enctype="multipart/form-data">
			<div class="profile-card col-12 table-profile-update form-row">
				<div class="image-upload">
					<label for="avatar" class="text-center">
						@if($data->avatar === null )
							<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%" alt="">
						@else
							<img src="{{ asset('') }}uploads/{{$data->avatar}}" width="90%" alt="">
						@endif
						<span>Click here to change avatar</span>
					</label>
					<input id="avatar" type="file" accept="image/*" name="avatar" class="disabled d-none">
				</div>
				<div class="profile-card-info float-left">
					<div class="form-row">
						<div class="form-group col-md-6">
							<span class="error-message-fname text-danger"></span>
							<label for="fname">
								First Name:
							</label>
							<input type="text" name="fname" id="fname" class="form-control inp-fname disabled"
							       placeholder="First Name" value="{{$data->fname}}" required>
						</div>
						<div class="form-group col-md-6">
							<span class="error-message-lname text-danger"></span>
							<label for="lname">
								Last Name:
							</label>
							<input type="text" name="lname" id="lname" class="form-control inp-lname disabled"
							       placeholder="Last Name" value="{{$data->lname}}" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<span class="error-message-lname text-danger"></span>
							<label for="dob">
								Date of birth:
							</label>
							<input type="date" name="dob" id="dob" class="form-control inp-dob disabled"
							       value="{{$data->short_dob}}">
						</div>
						<div class="form-group col-md-4">
							<span class="error-message-gender text-danger"></span>
							<label for="gender">Gender</label>
							<select name="gender" id="gender" class="form-control disabled">
								<option value="0" @if($data->gender === '1')
									selected
										@endif>
									Female
								</option>
								<option value="1">Male</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<span class="error-message-phone text-danger"></span>
							<label for="phone">
								Number phone:
							</label>
							<input type="text" name="phone" id="phone" class="form-control inp-phone disabled"
							       value="{{$data->phone}}" required>
						</div>
					</div>
					<div class="form-row disabled prevent">
						<div class="form-group col-md-6">
							<label for="department">Department</label>
							<input type="text" id="department" class="form-control na" value="{{session('dept_name')}}"
							       readonly>
						</div>
						<div class="form-group col-md-6">
							<label for="role">Role</label>
							<input type="text" id="role" class="form-control na" value="{{session('role_name')}}"
							       readonly>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-city text-danger"></span>
							<div class="form-group" id="city-select">
								<label for="city">
									City:
								</label>
								<select name="city" id="city" class="form-control select-city disabled"
								        data-city="{{$data->city}}"></select>
							</div>
						</div>
						<div class="form-group col-md-6 mb-0">
							<span class="error-message-district text-danger"></span>
							<div class="form-group" id="district-select">
								<label for="district">
									District:
								</label>
								<select name="district" id="district" data-district="{{$data->district}}"
								        class="form-control select-district disabled"></select>
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<span class="error-message-email text-danger"></span>
							<label for="email">
								Email:
							</label>
							<input type="text" id="email" class="form-control inp-email disabled"
							       value="{{$data->email}}" readonly>
						</div>
						<div class="form-group col-md-6">
							<span class="error-message-password text-danger"></span>
							<label for="password">
								Password:
							</label>
							<div class="input-group input-group-merge">
								<input type="password" name="password" id="password"
								       class="form-control inp-password disabled"
								       placeholder="********" required>
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
				<button class="btn btn-info">Change</button>
				<button class="btn btn-success d-none">Submit</button>
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
            $('.disabled').prop('disabled', true);
            let selectCity     = $('#city');
            let selectDistrict = $('#district');
            let avatar         = $('#avatar');
            let btnSave        = $('.btn-success');
            let btnChange      = $('.btn-info');

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

            btnChange.click(function (e) {
                e.preventDefault();
                $(this).addClass('d-none');
                btnSave.removeClass('d-none');
                $('.input-group-append').removeClass('d-none');
                $('.disabled').prop('disabled', false);
            })

            if (btnSave.hasClass('d-none')) {
                $('.input-group-append').addClass('d-none');
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
                data.set('city', city);
                data.set('district', district);
                $.ajax({
                    type       : "post",
                    url        : "{{ route('ceo.update_information') }}",
                    contentType: false,
                    processData: false,
                    data       : data,
                })
                    .done(function (response) {
                        btnSave.addClass('d-none');
                        $('.input-group-append').removeClass('d-none');
                        btnChange.removeClass('d-none');
                        $('.disabled').prop('disabled', true);
                        notifySuccess(response);
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
