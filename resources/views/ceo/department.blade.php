@extends('layout.master')
@include('ceo.menu')
@section('content')
@push('css')
    <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .div-dept {
        cursor: pointer;
    }
    .add-dept {
        background-color: bisque;
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
    <div class="col-12 p-2 border border-1 border-light bg-dark"   >
        <table class=" text-white  w-100">
                <tr>
                    <td class= "col-7">
                        <form id="form-change-dept" method="post" >
                            <div class="w-40">
                                <span class="tittle-pay-rate ">Departments</span>
                                <span class="change-dept"><i class="fa-solid fa-pen-to-square"></i></span>
                                <span class="exit-change-dept d-none"><i class="fa-solid fa-circle-xmark"></i></span>
                            </div>
                            <input type="hidden" name="dept_id" class="dept-id" >
                            <span class="dept-name-detail text-warning"></span> 
                            <input type="text" name="name" value="" class="d-none inp-dept">
                            <button  class="btn-change-dept d-none">
                            <i class="fa-solid fa-pen-to-square"></i></button>
                        </form>
                    </td>
                    <td class= "col-3">
                        <span class="tittle-pay-rate">Manager</span>
                        <br>
                        <span class="manager-name-detail text-warning"></span>
                    </td>
                    <td class= "col-1">
                        <span class="tittle-pay-rate">Role</span>
                        <br>
                        <span class="manager-role-detail text-warning"></span>
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
        <table class="table  table-hover">
            <thead class="thead-dark">
                <tr>
                    <th colspan="6">
                        <h2 class="text-white">Departments list</h2>
                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach($dept as $each)
                <tr class=" div-dept">
                    <td class="col-1"> 
                        <div class="form-group ">
                            <span>#</span>
                            <br>
                            <span class="dept-id text-danger">{{ $each->id }}</span>         
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">
                            <span>Name</span>
                            <br>
                            <span class="dept-name text-warning"></span>         
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">
                            <span>Members</span>
                            <br>
                            <span class="dept-members text-warning"></span>         
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">
                            <span>Manager</span>
                            <br>
                            <span class="manager-name text-warning"></span>         
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">
                            <span>Status</span>
                            <br>
                            <span class="dept-status text-warning">{{$each->status}}</span>         
                        </div>
                    </td>
                    <td>
                        <div class="form-group ">
                            <span>Action</span>
                            <br>       
                        </div>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
 {{-- form add department --}}
<div class="add-dept-div  d-none  " >
    
    <div class="add-dept col-6">
        <button class="btn-warning btn-form-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>
        <br>
        <form id="add-department" action="{{ route('ceo.department.store') }}" method="post" novalidate="novalidate">
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
                <select class="form-control" name="status" >
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
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
// searching by department
    <script type="text/javascript" >
       $(document).ready(function () {
            $.ajaxSetup({
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
           $('.div-dept').each(function () {    
                var dept_name = $(this).find('.dept-name');
                var manager_name = $(this).find('.manager-name');
                var dept_status = $(this).find('.dept-status');
                var members = $(this).find('.dept-members');
                $.ajax({
                    url: "{{ route('ceo.department_api') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        dept_id: $(this).find('.dept-id').text()
                    },
                    success: function (response) {
                        console.log();
                        dept_name.text(response.dept_name);
                        manager_name.text(response.fname + ' ' + response.lname);
                        dept_status.text(response.status);
                        dept_id = response.dept_id;
                        count(dept_id);
                    }
                });
            function count(dept_id){
                $.ajax({
                    url: "{{ route('ceo.department_count_employees') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function (response) {
                        members.text(response);
                    }
                })
            }
            });
// add department

            $('.btn-add-dept').click(function () {
                $('.add-dept-div').removeClass('d-none');
                $('.dept-list').addClass('d-none');
            });
            $('.btn-back').click(function () {
                $('.dept').addClass('d-none');
                $('.dept-list').removeClass('d-none');
                $('.dept-name-detail').removeClass('d-none');
                        $('.inp-dept').addClass('d-none');
                        $('.btn-change-dept').addClass('d-none');
                        $('.change-dept').removeClass('d-none');
                        $('.exit-change-dept').addClass('d-none');
            });
            $('.btn-form-back').click(function () {
                $('.dept-list').removeClass('d-none');
                $('.add-dept-div').addClass('d-none');
            })

// show the dept list
            $('.div-dept').click(function () {
                var dept_id = $(this).find('.dept-id').text();
                $('.dept').removeClass('d-none');
                $('.dept-list').addClass('d-none');
                 $.ajax({
                    url: "{{ route('ceo.department_api') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function (response) {
                        $('.dept-name-detail').text(response.dept_name);
                        $('.manager-name-detail').text(response.fname + ' ' + response.lname);
                        $('.manager-role-detail').text(response.role_name);
                        $('.dept-id').val(response.dept_id);
                        var dept_id = response.dept_id;
                        show_department(dept_id);
                    }
                });
            })
             

            function show_department(dept_id) {
                $.ajax({
                    url: "{{ route('ceo.department_employees') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function (response) {
                        $('.department_employees').html('');
                        $('.department_employees').append(
                            '<table class="table table-striped table-bordere table-hover table-sm">' +
                            '<thead class="thead-dark">' +
                            '<tr>' +
                            '<th class=" col-1 ">#</th>' +
                            '<th class=" col-1 ">Name</th>' +
                            '<th class=" col-1 ">Role</th>' +
                            '<th class=" col-1 ">Pay rate</th>' +
                            '<th class=" col-1 ">Action</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>' +
                            '<div class="col-12">'
                                );

                            $.each(response, function (index, value) {
                                $('.department_employees').append(
                                    '<tr>' +
                                    '<td class=" col-1 ">' + 
                                    '<div class="form-group">' + (index + 1) + '</div>' +
    	                            '</td>' +
                                    '<td class=" col-1 ">' + 
                                    '<div class="form-group">' + value.fname + ' ' + value.lname + '</div>' + 
                                    '</td>' +
                                    '<td class=" col-1 ">' + 
                                    '<div class="form-group">' +  value.role_name + '</div>' + 
                                    '</td>' +
                                    '<td class=" col-1 ">' + value.pay_rate + '</td>' +
                                    '<td class=" col-1 ">' +
                                    '<a href="#' + value.id + '" class="btn btn-primary btn-sm">Details</a>' +
                                    '</td>' +
                                    '</tr>'
                                );
                            });
                        $('.department_employees').append(
                            '</div>' +
                            '</tbody>'+
                            '</table>'
                            );
                    }
                });
            }

// change department
            $('.change-dept').click(function () {
                $(this).addClass('d-none');
                var dept_name = $('.dept-name-detail').text();
                $('.dept-name-detail').addClass('d-none');
                $('.inp-dept').removeClass('d-none');
                $('.inp-dept').val(dept_name);
                $('.btn-change-dept').removeClass('d-none');
                $('.exit-change-dept').removeClass('d-none');
            });
            $('.exit-change-dept').click(function () {
                $(this).addClass('d-none');
                $('.dept-name-detail').removeClass('d-none');
                $('.inp-dept').addClass('d-none');
                $('.btn-change-dept').addClass('d-none');
                $('.change-dept').removeClass('d-none');
            })

            $('#form-change-dept').submit(function (e) { 
                e.preventDefault();
                var form = $(this);
                $.ajax({
                    url: "{{ route('ceo.department.update') }}",
                    method: "POST",
                    datatype: 'json',
                    data: form.serialize(),
                    success: function (response) {
                        $('.dept-name-detail').removeClass('d-none');
                        $('.inp-dept').addClass('d-none');
                        $('.btn-change-dept').addClass('d-none');
                        $('.change-dept').removeClass('d-none');
                        $('.exit-change-dept').addClass('d-none');
                        $('.dept-name-detail').text(response.dept_name)
                    }
                })
                
            });
        });
    </script>
@endpush