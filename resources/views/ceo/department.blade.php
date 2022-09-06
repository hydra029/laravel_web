@extends('layout.master')
@include('ceo.menu')
@push('css')
	<style href="{{ asset('css/app.css') }}"></style>
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
            padding: 1rem;
        }

        .btn-add-roles {
            margin-left: 48%;
            margin-top: 10px;
        }

        .model-popup-div {
            background-color: rgba(0, 0, 0, 0.5);
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1100;
        }

        .model-popup {
            background-color: aliceblue;
            position: absolute;
            width: 500px;
            height: 300px;
            top: 20%;
            left: 40%;
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

        .profile-card {
            background-color: rgb(255, 255, 255);
            position: absolute;
            margin: 0;
            padding: 0;
            top: 100px;
            right: 5%;
            width: 80%;
            height: 600px;
            animation-name: popup;
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
        }

        .profile-card-roles {
            height: 25%;
        }

        .model-ask-delete, .popup-delete-department {
            background-color: aliceblue;
            position: absolute;
            width: 400px;
            height: 150px;
            top: 20%;
            left: 40%;
            opacity: 1;
            animation-name: popup;
            animation-duration: 1s;
        }
	</style>
@endpush
@section('content')
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
		<button class="btn-warning btn-back" type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
			back
		</button>
		<br>

		<div class="col-12 p-2 border border-1 border-light department_employees ">
			<table class="table table-striped table-striped" id="table-department-employees">
				<thead class="bg-light">
				<tr>
					<th class="col-1">#</th>
					<th class="col-1">Avatar</th>
					<th class="col-2">Name</th>
					<th class="col-5">Gender</th>
					<th class="col-2">Role</th>
					<th class="col-1">Action</th>
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
		<button class="btn-success btn-add-dept " type="button">
			Add
			<span class="btn-label">
                <i class="fa-solid fa-circle-plus"></i>
            </span>
		</button>
		<br>
		<div class="col-12 p-2 border border-1 border-light dept-list">
			<table class="table table-striped table-striped" id="table-list-department">
				<thead>
				<th class="col-1"><span>#</span></th>
				<th class="col-2"><span>Name</span></th>
				<th class="col-5"><span>Members</span></th>
				<th class="col-2"><span>Manager</span></th>
				<th class="col-1"><span>Action</span></th>

				</thead>
				<tbody>

				@foreach ($dept as $each)
					<tr class="div-dept">
						<td class="align-middle ">
							<div>
								<span class="dept-id text-danger">{{ $each->id }}</span><span>.</span>
							</div>
						</td>
						<td class="align-middle ">
							<div>
								<span class="dept-name ">{{ $each->name }}</span>
							</div>
						</td>
						<td class="align-middle ">
							<div>
                                    <span class="dept-members members-department ">
                                        @if($each->id ==1)
		                                    {{ $each->acctmembers_count }}
	                                    @else
		                                    {{ $each->members_count }}
	                                    @endif
                                        members</span>
							</div>
						</td>
						<td class="align-middle ">
							<div>
								@if ($each->manager === null)
									<span class="text-danger"> No manager yet</span>
								@else
									<span class="manager-id d-none">{{ $each->manager->id }}</span>
									<span class="manager-gender d-none">{{ $each->manager->gender_name }}</span>
									<span class="manager-dob d-none">{{ $each->manager->date_of_birth }}</span>
									<span class="manager-email d-none">{{ $each->manager->email }}</span>
									<span class="manager-phone d-none">{{ $each->manager->phone }}</span>
									<span class="manager-address d-none">{{ $each->manager->address }}</span>
									<span class="manager-role d-none">{{ $each->manager->role_id }}</span>
									<span class="manager-avatar d-none">{{ $each->manager->avatar }}</span>
									@if ($each->manager->avatar === null)
										<img class="manager-avatar-img"
										     src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}"
										     style=" border-radius:50% " width="40px" alt="">
									@else
										<img class="manager-avatar-img"
										     src="{{ asset('') }}img/{{ $each->manager->avatar }}"
										     style=" border-radius:50% " width="40px" alt="">
									@endif
									<a class="manager-name ">{{ $each->manager->full_name }}</a>
								@endif

							</div>
						</td>

						<td class="align-middle ">
							<div>
								<i class="fa-solid fa-eye btn-show-department text-primary"
								   data-id="{{ $each->id }}"></i>
								<i class="fa-solid fa-pen btn-edit-department text-warning"
								   data-id="{{ $each->id }}"></i>
								<i class="fa-solid fa-square-xmark btn-delete-department text-danger"
								   data-id="{{ $each->id }}"></i>
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>
			<nav aria-label="Page navigation example">
				<ul class="pagination float-right" id="department-pagination">
					{{ $dept->links() }}
				</ul>
			</nav>
		</div>
	</div>
	{{-- /////MODEL_LOCATIONS/// --}}
	<div class=" model-popup-div d-none">
		{{-- form add department --}}
		<div class="popup-add-department d-none model-popup">
			<form id="form-add-department" action="{{ route('ceo.department.store') }}" method="post">
				@csrf
				<div class="card-header card-header-icon" data-background-color="rose">
					<i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
					<span class=" card-title h2"> Add department</span>
				</div>
				<div class="card-content">
					<table class="table form-table">
						<tr>
							<td class="form-group">
								Name:
								<label>
									<input type="text" name="name" class="name-department form-control" value=""
									       placeholder="Name department" required>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<input type="hidden" name="status" value="1">
								Manager:
								<label>
									<select name="id_manager" class="form-control">
										<option value="" selected>No manager</option>
										@foreach ($manager as $each)
											<option value="{{ $each->id }}">{{ $each->full_name }}</option>
										@endforeach
									</select>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-primary btn-add-department float-right ml-1" type="submit">Submit
								</button>
								<button class="btn btn-light btn-close-model float-right" type="button">Cancel</button>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
		{{-- form edit department --}}
		<div class="popup-edit-department d-none model-popup">
			<div class="card-header card-header-icon" data-background-color="rose">
				<i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
				<span class=" card-title h2"> Edit department</span>
			</div>
			<form id="form-update-department" action="{{ route('ceo.department.update') }}" method="post"
			      class="form-horizontal">
				@csrf
				<table class="table form-table">
					<tr>
						<td class="form-group">
							<input type="hidden" name="id" value="" class="id-department-edit">
							Name:
							<label>
								<input type="text" name="name" class="name-department-edit form-control"
								       value="" placeholder="Name department" required>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="status" value="1">
							Manager:
							<label>
								<select name="manager" class="select-manager-edit form-control">
									<option value="" selected>No manager</option>
									@foreach ($manager as $each)
										<option value="{{ $each->id }}">{{ $each->full_name }}</option>
									@endforeach
								</select>
							</label>
						</td>
					</tr>
					<tr>
						<td>
							<button class="btn btn-primary btn-change-department float-right ml-1" type="submit">Submit
							</button>
							<button class="btn btn-light btn-close-model float-right" type="button">Cancel</button>
						</td>
					</tr>
				</table>
			</form>
		</div>
		{{-- ask delete members --}}
		<div class="model-ask-delete d-none">
			<div class="card-header card-header-icon" data-background-color="rose">
				<i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
				<span class=" card-title h3 "> Bạn có chắc chắn muốn xóa không?</span>
			</div>
			<table class="table form-table">
				<tr>
					<td>
						<button class="btn btn-light btn-close-model " type="button">Cancel</button>
					</td>
					<td>
						<button class="btn btn-danger btn-delete-members d-none" type="button">Yes</button>
						<button class="btn btn-danger btn-delete-departments d-none" type="button">Yes</button>
					</td>
				</tr>
			</table>
		</div>
		{{-- profile --}}
		<div class="profile-card d-none">
			<button class="btn-warning profile-close rounded-pill" style="right: 0;" type="button">
                <span class="btn-label">
                    <i class="fa-solid fa-circle-xmark"></i>
                </span>
				Close
			</button>
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
								<div>
									<i class="fa-solid fa-medal"></i>
									<i class="fa-solid fa-book-circle-arrow-right"></i>
									<span class="profile-card-department"></span>
								</div>
							</th>
							<th>
								<div>
									<span class="profile-card-role"></span>
								</div>
							</th>
						</tr>
					</table>
				</div>
			</div>
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
							<label>
								<input type="text" name="name" class="inp-role-name">
							</label>
							<input type="hidden" name="dept_id" class="inp-dept-role-id">
						</td>
						<td>
							<span>Pay rate: </span>
							<label>
								<input type="text" name="pay_rate" class="inp-role-pay_rate">
							</label>
						</td>
						<td>
							<button type="submit" name="" class="btn btn-primary btn-save-add-role">Save</button>
						</td>
					</tr>
				</table>
			</form>
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
							<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%" alt="">
							<span>Click here to chage avatar</span>
						</label>
						<input id="file-input" type="file" class="d-none"/>
					</div>
				</div>
				<div class="profile-card-info float-left">
					<div class="profile-card-info-basic">
						<table class="table">
							<tr>
								<td class="col-6">
									First Name:
									<br>
									<span class="error-message-fname text-danger"> </span><label>
										<input type="text"
										                                                             name="fname"
										                                                             class="form-control inp-fname"
										                                                             placeholder="First Name">
									</label>
								</td>
								<td>
									Last Name:
									<br>
									<span class="error-message-lname text-danger"> </span><label>
										<input type="text"
										                                                             name="lname"
										                                                             class="form-control inp-lname "
										                                                             placeholder="Last Name">
									</label>
								</td>
							</tr>
							<tr>
								<td>
									Gender:
								</td>
								<td>
									<label>
										<input type="radio" name="gender" value="1" class="inp-gender">
									</label> Male
									<span> / </span>
									<label>
										<input type="radio" name="gender" value="0" class="inp-gender">
									</label> Female
									<span class="error-message-gender text-danger "> </span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Date of birth:
									<br>
									<span class="error-message-dob text-danger"> </span> <label
											for="date"></label><label for="date"></label><label
											for="date"></label><input type="date"
									                                  name="dob" id="date"
									                                  class="form-control inp-dob"
									                                  style="width: 100%; display: inline;"
									                                  required value=""
									                                  placeholder="Date of birth">
								</td>
								<td></td>
							</tr>
							<tr>
								<td>
									City:
									<br>
									<span class="error-message-city text-danger"> </span><label
											for="select-city"></label><label for="select-city"></label><select name="city"
									                                                                           id="select-city"
									                                                                           class="form-control"></select>
								</td>
								<td>
									District:
									<br>
									<span class="error-message-district text-danger"> </span><label
											for="select-district"></label><label
											for="select-district"></label><select name="district"
									                                              id="select-district"
									                                              class="form-control"></select>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Number phone:
									<br>
									<span class="error-message-phone text-danger"> </span> <label>
										<input type="number"
										                                                              name="phone" value=""
										                                                              placeholder="Number phone"
										                                                              class="form-control inp-phone">
									</label>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Email:
									<br>
									<span class="error-message-email text-danger"> </span><label>
										<input type="email"
										                                                             name="email" value=""
										                                                             placeholder="Email"
										                                                             class="form-control inp-email">
									</label>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									Password:
									<span toggle="#password-field"
									      class="fa fa-fw fa-eye field_icon toggle-password"></span>
									<br>
									<span class="error-message-password text-danger"> </span> <label>
										<input type="password"
										                                                                 name="password"
										                                                                 value=""
										                                                                 placeholder="Password"
										                                                                 class="form-control inp-password">
									</label>
								</td>
							</tr>
							<tr>
								<td>
									<span>department</span>
									<span class="error-message-dept_id text-danger"> </span>
									<label for="select-department"></label><label
											for="select-department"></label><label
											for="select-department"></label><select id="select-department" name="dept_id" class="form-control inp-dept_id">
										@foreach ($dept as $each)
											<option value="{{ $each->id }}">{{ $each->name }}</option>
										@endforeach
									</select>
								</td>
								<td>
									<span>role</span>
									<span class="error-message-role_id text-danger"> </span>
									<label for="select-role"></label><select id="select-role" name="role_id" class="form-control inp-role_id"></select>
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
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	<script src="{{ asset('js/imgHover.js') }}"></script>
	<script type="text/javascript">
        $(document).ready(async function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // add department
            $('.btn-close-model').click(function () {
                $('.model-popup-div ').addClass('d-none');
                $('.model-popup').addClass('d-none');
                $('.model-popup').find('form')[0].reset();
            });
            $('.btn-add-dept').click(function () {
                $('.model-popup-div ').removeClass('d-none');
                $('.popup-add-department').removeClass('d-none');
            });
            $('.btn-back').click(function () {
                $('.model-popup-div ').addClass('d-none');
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
            $('.btn-form-back').click(function () {
                $('.title-name').text('');
                $('.dept-list').removeClass('d-none');
                $('.add-dept-div').addClass('d-none');
            })
            $('.btn-back-roles').click(function () {
                $('.title-name').text('');
                $('.dept-list').removeClass('d-none');
                $('.dept-roles').addClass('d-none');
            })


            // edit department
            $('.btn-edit-department').click(function () {
                let dept_row = $(this).parents('tr');
                $('.model-popup-div ').removeClass('d-none');
                $('.model-popup').removeClass('d-none');
                $('.popup-edit-department').removeClass('d-none');
                let dept_id    = $(this).data('id');
                let dept_name  = $(this).parents('tr').find('.dept-name').text();
                let id_manager = $(this).parents('tr').find('.manager-id').text();
                $('.id-department-edit').val(dept_id);
                $('.name-department-edit').val(dept_name);
                $('.select-manager-edit').find('option').each(function () {
                    if ($(this).val() === id_manager) {
                        $(this).attr('selected', 'selected');
                    }
                });
                $('#form-update-department').submit(function (e) {
                    e.preventDefault();
                    let form = $(this);
                    $.ajax({
                        url     : "{{ route('ceo.department.update') }}",
                        method  : "POST",
                        datatype: 'json',
                        data    : form.serialize(),
                        success : function (response) {
                            let img;
                            if (response[0].manager.avatar === null) {
                                img =
                                    '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}';
                            } else {
                                img = '{{ asset('') }}' + 'img/' + response[0]
                                    .manager.avatar;
                            }
                            $('.model-popup-div ').addClass('d-none');
                            $('.model-popup').addClass('d-none');
                            $('.popup-edit-department').addClass('d-none');
                            dept_row.find('.dept-name').text(response[0].name);
                            dept_row.find('.manager-id').text(response[0].manager
                                .id);
                            dept_row.find('.manager-name').text(response[0].manager
                                .full_name);
                            dept_row.find('.manager-avatar-img').attr('src', img);
                            dept_row.find('.manager-gender').text(response[0]
                                .manager.gender_name);
                            dept_row.find('.manager-dob').text(response[0].manager
                                .date_of_birth);
                            dept_row.find('.manager-email').text(response[0].manager
                                .email);
                            dept_row.find('.manager-phone').text(response[0].manager
                                .phone);
                            dept_row.find('.manager-role').text(response[0].manager
                                .role);
                            dept_row.find('.manager-address').text(response[0]
                                .manager.address);
                            dept_row = '';
                        }
                    })
                });
            });

            $('.btn-delete-department').click(function () {
                let dept_row = $(this).parents('tr');
                let dept_id  = $(this).data('id');
                $('.model-popup-div ').removeClass('d-none');
                $('.model-ask-delete').removeClass('d-none');
                $('.btn-delete-departments').removeClass('d-none');
                $(".model-ask-delete").find(".btn-delete-departments").data('id', dept_id);
                $('.btn-delete-departments').click(function () {
                    $.ajax({
                        type    : "POST",
                        url     : "{{ route('ceo.department.destroy') }}",
                        data    : {
                            dept_id: dept_id,
                        },
                        dataType: "json",
                        success : function (response) {
                            dept_row.remove();
                            $('.model-popup-div ').addClass('d-none');
                            $('.model-popup').addClass('d-none');
                            $('.btn-delete-departments').addClass('d-none');
                        }
                    })
                });
            });

            // show the members list
            let dept_list = [];
            $('.btn-show-department').click(function () {
                $('.dept').removeClass('d-none');
                $('.dept-list').addClass('d-none');
                let dept_id      = $(this).data('id');
                let dept_name    = $(this).parents('tr').find('.dept-name').text();
                let manager_name = $(this).parents('tr').find('.manager-name').text();
                let url;
                if (dept_id == 1) {
                    url = "{{ route('ceo.department_accountants') }}";
                } else {
                    url = "{{ route('ceo.department_employees') }}";
                }

                $('.title-name').text(` > ${dept_name}`);
                $('.dept-name-detail').text(dept_name);
                $('.manager-name-detail').text(manager_name);
                $('#table-department-employees').find('tbody').empty();
                $.ajax({
                    url     : url,
                    method  : "POST",
                    datatype: 'json',
                    data    : {
                        dept_id: dept_id
                    },
                    success : function (response) {

                        $.each(response.data.data, function (index, value) {
                            if (value.avatar == null) {
                                let img =
                                        `<img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" style=" border-radius:50% " width="40px">`
                            } else {
                                let img =
                                        `<img  src="{{ asset('') }}img/${value.avatar} "  style=" border-radius:50% " width="40px"/>`
                            }
                            $('#table-department-employees').append($(
                                '<tr class="employee-row">')
                                .append($('<td class="align-middle">').append((
                                    index + 1) + '.'))
                                .append($('<td class="align-middle">').append(
                                    img
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
                links.forEach(function (each) {
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
                $(document).on('click', '#employees-pagination > li > a', function (event) {
                    event.preventDefault();
                    let url = $(this).attr('href');
                    console.log(url);
                    $('#table-department-employees').find('tbody').empty();
                    $.ajax({
                        url     : url,
                        method  : "POST",
                        datatype: 'json',
                        data    : {
                            dept_id: dept_id
                        },
                        success : function (response) {

                            $.each(response.data.data, function (index, value) {
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
                $('.btn-show-employee').click(function () {
                    let id = $(this).data('id');
                    $('.model-popup-div ').removeClass('d-none');
                    $.ajax({
                        type    : "post",
                        url     : "{{ route('ceo.employee_infor') }}",
                        data    : {
                            id: id,
                        },
                        dataType: "json",
                        success : function (response) {
                            console.log(response);
                            $('.profile-card').removeClass('d-none');
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-name').text(response[0].full_name);
                            $('.profile-card').find('.profile-card-info').find(
                                '.profile-card-gender').text(response[0].gender_name);
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
                                let src = '{{ asset('') }}';
                                let img = src + 'img/' + response[0].avatar;
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

            function update_emp() {
                $('.btn-edit-employee').click(function (e) {
                    let id = $(this).data('id');
                    $('.div-form-update-employee').removeClass('d-none');
                    $('.dept').addClass('d-none');
                    $.ajax({
                        type    : "post",
                        url     : "{{ route('ceo.employee_infor') }}",
                        data    : {
                            id: id,
                        },
                        dataType: "json",
                        success : function (response) {
                            console.log(response);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '.inp-fname').val(response[0].fname);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '.inp-dob').val(response[0].dob);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '.inp-lname').val(response[0].lname);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '.inp-phone').val(response[0].phone);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '.inp-email').val(response[0].email);
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '#select-city').find('option').each(function () {
                                if ($(this).val() == response[0].city) {
                                    $(this).attr('selected', 'selected');
                                }
                                ;
                            });
                            $('.profile-card-edit').find('.profile-card-info').find(
                                '#select-department').find('option').each(function () {
                                if ($(this).val() == response[0].dept_id) {
                                    $(this).attr('selected', 'selected');
                                }
                                ;
                            });

                            if (response[0].avatar == null) {
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src',
                                        '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}'
                                    );
                            } else {
                                let src = '{{ asset('') }}';
                                let img = src + 'img/' + response[0].avatar;
                                $('.profile-card').find('.profile-card-img').find('img')
                                    .attr('src', img);
                            }
                        }
                    });
                });
            }

            $('.btn-back-form-update-employee').click(function (e) {
                $('.dept').removeClass('d-none');
                $('.div-form-update-employee').addClass('d-none');
            })


            function delete_emp() {
                $('.btn-delete-employee').click(function () {
                    let employee_delete = $(this).parents('tr');
                    let id              = $(this).data('id');
                    $(".model-popup-div").removeClass('d-none');
                    $(".model-ask-delete").removeClass('d-none');
                    $(".btn-delete-members").removeClass('d-none');
                    $(".model-ask-delete").find(".btn-delete-members").data('id', id);
                    $('.btn-delete-members').click(function () {
                        $.ajax({
                            type    : "delete",
                            url     : `{{ route('ceo.delete_emp') }}`,
                            data    : {
                                "id": id,
                            },
                            dataType: "json",
                            success : function (response) {
                                employee_delete.remove();
                                $(".model-ask-delete").addClass('d-none');
                                $(".model-popup-div").addClass('d-none');
                                $(".btn-delete-members").addClass('d-none');
                            }
                        });
                    })
                })
            }

            // change department

            // form


            let array = [
                'fname',
                'lname',
                'gender',
                'dob',
                'phone',
                'email',
                'password',
            ];
            $.each(array, function (index, each) {
                let text = each;
                console.log(text);
                $(`.inp-${each}`).on("change paste keyup", function (text) {
                    $(`.error-message-${each}`).empty();
                });
            })

            $('#form-update-employees').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    type    : 'post',
                    url     : "{{ route('ceo.update_emp') }}",
                    data    : form.serialize(),
                    dataType: 'json',
                    success : function (response) {
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
                            $('.profile-card').find('.profile-card-img').find(
                                '.image-upload').find('img').attr(
                                'src',
                                '{{ asset('img/istockphoto-1223671392-612x612.jpg') }}'
                            );
                        } else {
                            let src = '{{ asset('') }}';
                            let img = src + 'img/' + response[0].avatar;
                            $('.profile-card').find('.profile-card-img').find(
                                '.image-upload').find('img').attr(
                                'src', img);
                        }
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-role').text(response[0].roles.name);
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-department').text(response[0].departments
                            .name);

                        $('#form-update-employees')[0].reset();

                    },
                    error   : function (xhr, textStatus, errorThrown) {
                        let err = JSON.parse(xhr.responseText);
                        $.each(err.errors, function (key, value) {
                            $(`.error-message-${key}`).text(value);
                        })
                    }
                });
            });
            $('#select-city').select2();
            const response = await fetch('{{ asset('locations/index.json') }}');
            const cities   = await response.json();
            $.each(cities, function (index, each) {
                $('#select-city').append(
                    `<option value='${each.code}' data-path='${each.file_path}'>${index}</option>`);
            });
            $('#select-city').change(function () {
                loadDistrict();
            })
            loadDistrict();
            $('#select-district').select2();

            async function loadDistrict() {
                $('#select-district').empty();
                const path      = $("#select-city option:selected").data('path');
                const response  = await fetch('{{ asset('locations/') }}' + path);
                const districts = await response.json();
                $.each(districts.district, function (index, each) {
                    if (each.pre === "Quận" || each.pre === "Huyện") {
                        $('#select-district').append(`
                            <option>
                                ${each.name}
                            </option>`);
                    }
                });
            }

            let dept_id = $("#select-department").val();
            select_role(dept_id);
            $("#select-department").change(function () {
                let dept_id = $(this).val();
                select_role(dept_id);
            });

            function select_role(dept_id) {
                $("#select-role").empty();
                $.ajax({
                    type    : "post",
                    url     : "{{ route('ceo.select_role') }}",
                    data    : {
                        dept_id: dept_id
                    },
                    dataType: "json",
                    success : function (response) {
                        $.each(response, function (index, value) {
                            $("#select-role").append($('<option value="' + value.id + '">' +
                                value.name + '</option>'))
                        })
                    }
                });
            }

            // views profile manager

            $('.manager-name').click(function (e) {
                // values: e.clientX, e.clientY, e.pageX, e.pageY
                // over
                $('.model-popup-div ').removeClass('d-none');
                let id_manager      = $(this).parents('tr').find('.manager-id').text();
                let name_manager    = $(this).parents('tr').find('.manager-name').text();
                let gender_manager  = $(this).parents('tr').find('.manager-gender').text();
                let dob_manager     = $(this).parents('tr').find('.manager-dob').text();
                let email_manager   = $(this).parents('tr').find('.manager-email').text();
                let phone_manager   = $(this).parents('tr').find('.manager-phone').text();
                let address_manager = $(this).parents('tr').find('.manager-address').text();
                let id_role_manager = $(this).parents('tr').find('.manager-role').text();
                let avatar_manager  = $(this).parents('tr').find('.manager-avatar').text();
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
                    let src = '{{ asset('') }}';
                    let img = src + 'img/' + avatar_manager;
                    $('.profile-card').find('.profile-card-img').find('img').attr('src', img);
                }
                $.ajax({
                    url     : "{{ route('ceo.department.manager_role') }}",
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        role_id: id_role_manager,
                    },
                    success : function (response) {
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-role').text(response[0]['name']);
                        $('.profile-card').find('.profile-card-roles').find(
                            '.profile-card-department').text();
                    }
                })

                $('.profile-card').removeClass('d-none');


            });
            $('.profile-close').click(function () {
                $('.model-popup-div ').addClass('d-none');
                $('.profile-card').addClass('d-none');
            });
            $('.toggle-password').click(function () {
                $(this).toggleClass("fa-eye fa-eye-slash");

                let input = $(".inp-password");

                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            })
        });
	</script>
@endpush
