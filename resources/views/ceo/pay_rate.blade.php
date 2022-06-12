@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .icon-dropdown {
            width: 30px;
            height: 30px;
            border: 2px solid rgb(218, 203, 203);
            border-radius: 50%;
            position: relative;
        }
        .icon-dropdown::before {
            content: '';
            position: absolute;
            top: 7px;
            left: 9px;
            width: 9px;
            height: 9px;
            border-left: 2px solid rgb(185, 160, 160);
            border-bottom: 2px solid rgb(233, 220, 220);
            transform: rotate(-45deg);
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
    <div class="sumo suma">
    </div>
        @foreach ($dept as $each)
            <div class="dept">
                <div class="col-12 p-2 border border-1 border-light dept-name bg-dark"  data-id="{{ $each->id }}" >
                    <table class=" text-white  w-100">
                            <tr>
                                <td class= "col-7">
                                    <span class="tittle-pay-rate">Departments</span>
                                    <br>
                                    <span class="text-warning">
                                    {{$each -> name}}
                                    </span>
                                </td>
                                <td class= "col-3">
                                    <span class="tittle-pay-rate">Manager</span>
                                    <br>
                                    <span class="manager-name text-warning"></span>
                                </td>
                                <td class= "col-1">
                                    <span class="tittle-pay-rate">Role</span>
                                    <br>
                                    <span class="manager-role text-warning"></span>
                                </td>
                                <td class="col-1">
                                    <div class="icon-dropdown"></div>
                                </td>
                            </tr>
                    </table>
                </div>
                <div class="col-12 p-2 border border-1 border-light pay-rate d-none  ">
                </div>
            </div>
        @endforeach
    </table>

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
            window.addEventListener("load", function(){
                $('.sumo').click();
              
                });
            $('.sumo').on('click', function () {
                $('.dept-name').click();
                $('suma').removeClass('sumo');
            });
                $('.dept-name').click(function () {
                var pay_rate = $(this).parents('.dept').find('.pay-rate');
                var dept_id = $(this).parents('.dept').find('.dept-name').attr('data-id');
                var manager_name = $(this).parents('.dept').find('.manager-name');
                var manager_role = $(this).parents('.dept').find('.manager-role');
                show();
                if(pay_rate.hasClass('d-none')){
                    $(this).find('.title-pay-rate').addClass('text-dark');
                    pay_rate.removeClass('d-none');
                }else{
                    $(this).find('.title-pay-rate').addClass('text-dark')
                    pay_rate.addClass('d-none');
                }

                    console.log(1);
                $.ajax({
                    url: '{{ route('ceo.manager_name') }}',
                    type: 'POST',
                    data: {
                        dept_id: dept_id
                    },
                    success: function (response) {
                        console.log(response);
                        manager_name.text(response['fname'] + ' ' + response['lname']);
                        manager_role.text(response['role_name']);
                        
                    }
                })
                function show() {
                                $.ajax({
                            url: '{{route('ceo.pay_rate_api')}}',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                dept_id: dept_id
                            },
                            success: function (response) {
                                pay_rate.html('');
                                pay_rate.append('<table class="table table-striped table-centered mb-20 table-bordered text-center student-table-index">' +
                                    '<thead >' +
                                    '<tr class="bg-light">' +
                                    '<th>Roles</th>' +
                                    '<th>Pay rate</th>' +
                                    '<th>Change</th>' +
                                    '</tr>' +
                                    '</thead>' +
                                    '<tbody>')
                                $.each(response, function (index, value) {
                                    pay_rate.append('<tr>' +
                                        '<form id="form-payRate-change" method="post">' +
                                        '<td class="col-1">' +
                                        '<div class="role-name text-center form-group">' +
                                        value.role_name +
                                        '</div>' +
                                        '<label class="role-name-inp d-none">' +
                                        '<input type="text" name="role_id" class="form-control text-center" value="' + value.role_id + '">' +
                                        '</label>' +
                                        '</td>' +
                                        '<td class="col-1">' +
                                        '<div class="pay-rate text-center">' +
                                        value.pay_rate +
                                        '</div>' +
                                        '<label class="pay-rate-inp d-none">' +
                                        '<input type="text" name="pay_rate" class="form-control text-center" value="' + value.pay_rate + '">' +
                                        '</label>' +
                                        '</td>' +
                                        '<td class="col-1 ">' +
                                        '<div class="text-center">' +
                                        '<button type="button" class="btn btn-primary btn-change">' +
                                        'Change' +
                                        '</button>' +
                                        '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' + value.pay_rate+ '" data-dept_id ="' + value.dept_id + '" data-role_id ="' + value.role_id + '">' +
                                        'Save' +
                                        '</button>' +
                                        '</div>' +
                                        '</td>' +
                                        '</form>' +
                                        '</tr>'+
                                        '</tbody>'+
                                        '</table>')
                                });
                                change();
                            }
                        });
                    }
                });

               
                function change(){
                            
                    $('.btn-change').click(function (event) {
                        $(this).addClass('d-none');
                        $(this).parents('tr').find('.btn-save').removeClass('d-none');
                        $(this).parents('tr').find('.pay-rate-inp').removeClass('d-none');
                        $(this).parents('tr').find('.pay-rate').addClass('d-none');
                    });
                    $('.btn-save').click(function (event) {
                        let tr = $(this).parents('tr');
                        const pay_rate_regex = /^[0-9]{6,9}$/;
                        let data = tr.find('.pay-rate-inp').find('input[name="pay_rate"]').val();
                        let dept_id = $(this).data('dept_id');
                        let role_id = $(this).data('role_id');
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
                                        dept_id: dept_id,
                                        role_id: role_id,
                                    },
                                    success:function (response) {
                                        tr.find('.btn-change').removeClass('d-none');
                                        tr.find('.btn-save').addClass('d-none');
                                        tr.find('.pay-rate-inp').addClass('d-none');
                                        tr.find('.pay-rate').removeClass('d-none');
                                        tr.find('.pay-rate').text(response[0]["pay_rate"]);
                                        $.notify('Action completed', 'success');
                                    }
                                })
                    })
                }
            });
    </script>
@endpush