@extends('layout.master')
@include('ceo.menu')
@section('content')
	@push('css')
		<style>
            ul li {
                list-style-type: none;
            }

            a, i, img {
                cursor: pointer;
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
	<div class="col-12">
		<div class="col-1 position-fixed">
			<div id="role-list" class="list-group">
				@foreach($dept as $dk => $dv)
					<a class="list-group-item list-group-item-action"
					   href="#list-item-{{ $dv->id }}">{{ $dv->name}}</a>
				@endforeach
			</div>
		</div>
		<div class="col-11 " style="margin-left: 10%" data-spy="scroll" data-target="#role-list" data-offset="1"
		     class="scrollspy-example">
			@foreach($dept as $dk => $dv)
				<table class="table">
					<tr class="bg-secondary " id="list-item-{{ $dv->id }}">
						<td colspan="3">
							<span class="mr-2 text-white">#{{ $dk + 1 }}.</span>
							<span class="mr-2 text-white">{{ $dv->name}}</span>
							<i class="fa-solid fa-circle-plus text-success h5 m-0 btn-add-role"
							   data-id="{{ $dv->id}}"></i>

						</td>
						<td>
							<div style="border-radius: 50%; width: 10px; height: 10px; display: inline-block"
							     class="bg-danger float-right mr-1"></div>
							<div style="border-radius: 50%; width: 10px; height: 10px; display: inline-block"
							     class="bg-warning float-right mr-1"></div>
							<div style="border-radius: 50%; width: 10px; height: 10px; display: inline-block"
							     class="bg-primary float-right mr-1"></div>
						</td>
					</tr>
					<tr class="text-primary bg-light">
						<td>id</td>
						<td>Name</td>
						<td>Pay rate</td>
						<td>Action</td>
					</tr>
					@foreach($dv->roles as $rk => $rv)
						<tr>
							<td class="col-2">
								<span>{{ $rk + 1 }}.</span>
							</td>
							<td class="col-4">
								<span>{{ $rv->name}}</span>
							</td>
							<td class="col-5">
								<span>{{ $rv->pay_rate_money}}</span>
							</td>
							<td class="col-1">
								<i class="fa-solid fa-pen btn-edit-role text-warning"
								   data-id="{{ $rv->id }}"
								   data-dept_id="{{$dv->id }}"
								   data-name="{{ $rv->name }}"
								   data-pay_rate="{{ $rv->pay_rate }}"
								></i>
								<i class="fa-solid fa-square-xmark btn-delete-role text-danger"
								   data-id="{{ $rv->id }}"></i>
							</td>
						</tr>
					@endforeach
				</table>
			@endforeach
		</div>
	</div>
	<div class=" model-popup-div d-none">
		<div class="popup-add-roles d-none model-popup " align="center">
			<form id="" action="" method="post">
				@csrf
				<div class="card-header card-header-icon" data-background-color="rose">
					<i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
					<span class=" card-title h2 title-popup"></span>
				</div>
				<div class="card-content">
					<table class="table form-table">
						<tr>
							<td class="form-group" width="100%" valign="top">
								<input type="hidden" name="id" class="role-id form-control" value="">
								<input type="hidden" name="dept_id" class="dept-id form-control" value="" required>
								Name:
								<label>
									<input type="text" name="name" class="name-role form-control" value=""
									       placeholder="Name role" required>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								Pay rate:
								<label>
									<input type="text" name="pay_rate" class="pay-rate form-control" value=""
									       placeholder="Pay rate" required>
								</label>
							</td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-primary btn-add-roles float-right ml-1"
								        type="submit">Submit
								</button>
								<button class="btn btn-light btn-close-model float-right" type="button">Cancel</button>
							</td>
						</tr>
					</table>
				</div>
			</form>
		</div>
		<div class="model-ask-delete d-none">
			<div class="card-header card-header-icon" data-background-color="rose">
				<i class="fa-solid fa-address-book fa-2x" aria-hidden="true"></i>
				<span class=" card-title h3 "> Are you sure you want to delete?</span>
			</div>
			<table class="table form-table">
				<form action="" method="post">
					<tr>
						<input type="hidden" name="id" value="" class="delete-id"/>
					</tr>
					<tr>
						<td align="center" valign="top">
							<button class="btn btn-light btn-close-model " type="button">Cancel</button>
						</td>
						<td align="center" valign="top">
							<button class="btn btn-danger btn-delete-role" type="button">Yes</button>
						</td>
					</tr>
				</form>
			</table>
		</div>
	</div>
@endsection
@push('js')
	<script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            let modelPopup = $('.model-popup');
            let list       = $('.list-group-item-action');
            $('.btn-close-model').click(function () {
                $('.model-popup-div ').addClass('d-none');
                modelPopup.addClass('d-none');
                modelPopup.find('form')[0].reset();
            });

            $('.btn-add-role').click(function () {
                const table = $(this).closest('table');
                $('.model-popup-div ').removeClass('d-none');
                modelPopup.removeClass('d-none');
                modelPopup.find('form')[0].reset();
                $('.dept-id').val($(this).data('id'));
                $('.title-popup').text('Add Roles');
                modelPopup.find('form').submit(function (e) {
                    e.preventDefault();
                    let form     = $(this);
                    let formData = new FormData(form[0]);
                    $.ajax({
                        url        : "{{ route('ceo.roles.store') }}",
                        type       : 'POST',
                        data       : formData,
                        contentType: false,
                        processData: false,
                        success    : function (response) {
                            if (response.success === true) {
                                $('.model-popup-div ').addClass('d-none');
                                modelPopup.addClass('d-none');
                                modelPopup.find('form')[0].reset();
                                notifySuccess(response.message)
                            }

                            if (response.success === false) {
                                $('.model-popup-div ').addClass('d-none');
                                modelPopup.addClass('d-none');
                                modelPopup.find('form')[0].reset();
                                notifyError(response.message)
                            }
                        }

                    });
                });

            });

            $('.btn-edit-role').click(function () {
                $('.model-popup-div ').removeClass('d-none');
                modelPopup.removeClass('d-none');
                modelPopup.find('form')[0].reset();
                $('.role-id').val($(this).data('id'));
                $('.dept-id').val($(this).data('dept_id'));
                $('.name-role').val($(this).data('name'));
                $('.pay-rate').val($(this).data('pay_rate'));
                $('.title-popup').text('Edit role');
                modelPopup.find('form').attr('action', '{{ route('ceo.roles.update') }}');
            });

            $('.btn-delete-role').click(function () {
                $('.model-popup-div ').removeClass('d-none');
                $('.model-ask-delete').removeClass('d-none');
                $('.delete-id').val($(this).data('id'));
                $('.model-ask-delete').find('form').attr('action', '{{ route('ceo.roles.destroy') }}');
            });
            list.click(function () {
                list.removeClass('active');
                $(this).addClass('active');
            })
        });
	</script>
@endpush
