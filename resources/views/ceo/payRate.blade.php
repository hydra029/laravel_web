@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
        <div class="form-group text-center ">
            <h1>Departments</h1>
        </div>
        @foreach ($dept as $each)
            <div class="dept">
                 <div class="col-12 p-2 border border-1 border-light btn dept-name"  data-id="{{ $each->id }}" align="center">
                    {{$each -> name}}
                </div>
                <div class="col-12 p-2 border border-1 border-light pay-rate d-none">

                </div>
            </div>
               
           
        @endforeach
    </table>
{{-- 
    <table class="table table-striped table-centered mb-20 table-bordered text-center" id="student-table-index">
        <div class="form-group">
              <select name="dept_search" id="dept-search" class="form-control col-4"></select>
        </div>
      
        <thead>
            <tr>
                <th>Departments</th>
                <th>Roles</th>
                <th>Pay rate</th>
                <th>Change</th>
            </tr>
        </thead>
        @foreach($pay_rate as $each)
            <tr>
                <form id="form-payRate-change" method="post">
                    <td class="col-2">
                        <div class="dept-name">
                            {{$each -> dept_name}}
                        </div>
                        <label class="dept-name-inp d-none">
                            <input type="text" name="dept_id" class="form-control text-center"
                                   value="{{$each -> dept_id}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="role-name">
                            {{$each -> role_name}}
                        </div>
                        <label class="role-name-inp d-none">
                            <input type="text" name="role_id" class="form-control text-center"
                                   value="{{$each -> role_id}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="pay-rate">
                            {{($each -> pay_rate)}}
                        </div>
                        <label class="pay-rate-inp d-none">
                            <input type="text" name="pay_rate" class="form-control text-center" value="{{$each -> pay_rate}}" >
                        </label>
                    </td>

                    <td class="col-2">
                        <button type="button" class="btn btn-primary btn-change">
                            Change
                        </button>
                        <button type="button" class="btn btn-primary btn-save d-none" 
                        data-id="{{$each->dept_id, $each->role_id}}">
                            Save
                        </button>
                    </td>
                </form>
            </tr>
        @endforeach
    </table> --}}
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
            $('.dept-name').click(function (event) {
                var pay_rate = $(this).parents('.dept').find('.pay-rate');
                if(pay_rate.hasClass('d-none')){
                    pay_rate.removeClass('d-none');
                }else{
                    pay_rate.addClass('d-none');
                }

                    console.log(1);
                    
                $.ajax({
                    url: '{{route('ceo.payRateApi')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        dept_id: $(this).parents('.dept').find('.dept-name').attr('data-id')
                    },
                    success: function (response) {
                        pay_rate.html('');
                        pay_rate.append('<table class="table table-striped table-centered mb-20 table-bordered text-center student-table-index">' +
                            '<thead>' +
                            '<tr>' +
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
                                '<div class="role-name">' +
                                value.role_name +
                                '</div>' +
                                '<label class="role-name-inp d-none">' +
                                '<input type="text" name="role_id" class="form-control text-center" value="' + value.role_id + '">' +
                                '</label>' +
                                '</td>' +
                                '<td class="col-1">' +
                                '<div class="pay-rate">' +
                                value.pay_rate +
                                '</div>' +
                                '<label class="pay-rate-inp d-none">' +
                                '<input type="text" name="pay_rate" class="form-control text-center" value="' + value.pay_rate + '">' +
                                '</label>' +
                                '</td>' +
                                '<td class="col-1">' +
                                '<button type="button" class="btn btn-primary btn-change">' +
                                'Change' +
                                '</button>' +
                                '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' + value.pay_rate+ '" data-dept_id ="' + value.dept_id + '" data-role_id ="' + value.role_id + '">' +
                                'Save' +
                                '</button>' +
                                '</td>' +
                                '</form>' +
                                '</tr>'+
                                '</tbody>'+
                                '</table>')
                        });
                        change();
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
                        const time_regex = /^[0-9]{6,9}$/;
                        let data = tr.find('.pay-rate-inp').find('input[name="pay_rate"]').val();
                        let text = data.substr(0, data.length - 1);
                        let dept_id = $(this).data('dept_id');
                        let role_id = $(this).data('role_id');
                        console.log(data);
                        if (data.match(time_regex)) {
                            console.log('success');
                        }

                        $.ajax({
                                    url: "{{ route('ceo.payRate_change') }}",
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
        });
    </script>
@endpush