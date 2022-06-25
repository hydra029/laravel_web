@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .div-change-page {
                width: 200px;
                top: -40px
            }

            .div-change-page .change-page {
                background-color: rgb(234, 226, 226);
                width: 100px;
                margin-bottom: 10px;
                border: 1px rgb(242, 199, 199) solid;
                cursor: pointer;
            }

            .div-change-page .change-page span {
                line-height: 30px
            }
        </style>
    @endpush
    <div class="position-absolute div-change-page">
        <table class="table col-12">
            <tr class="text-center">
                <td class="p-0">
                    <div class="change-page bg-dark text-white pay-rate-view">
                        <span>Pay rate</span>
                    </div>
                </td>
                <td class="p-0">
                    <div class="change-page fines-view">
                        <span>Fines</span>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="dept">
        <div class="col-12 p-2 border border-1 border-light dept-name bg-dark">
            <table class=" text-white  w-100">
                <tr>
                    <td class="col-4">
                        <span class="tittle-pay-rate">Departments</span>
                        <br>
                        <div id="select">
                            <select name="" id="select-dept" class="bg-dark text-warning">
                                @foreach ($dept as $each)
                                    @if ($each->id == 1)
                                        <option value="{{ $each->id }}" selected>
                                            {{ $each->name }}
                                        </option>
                                    @else
                                        <option value="{{ $each->id }}" class="">
                                            {{ $each->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </td>
                    <td class="col-8">
                        <div class="icon-dropdown">
                            <h2 class="tittle-pay-rate text-warning ">Basic salary for each position</h2>
                        </div>
                </tr>
            </table>
        </div>
        <div class="col-12 p-2 border border-1 border-light pay-rate">
        </div>
    </div>
    <div class="fines d-none">
        <div class="col-12 p-2 border border-1 border-light bg-dark text-white ">
            <div class="text-center">
                <h2 class="tittle-pay-rate text-warning ">Deduction corresponding to the error</h2>
            </div>
        </div>
        <div class="col-12 p-2 border border-1 border-light fines-details">
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    // searching by department
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.title-name').text(' > Pay Rate');
            var dept_id = 1;
            var pay_rate = $('.pay-rate');
            show(dept_id);
            $('#select-dept').change(function() {
                dept_id = $(this).val();
                show(dept_id);
            });


            function show(dept_id) {
                $.ajax({
                    url: '{{ route('ceo.pay_rate_api') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        dept_id: dept_id
                    },
                    success: function(response) {

                        pay_rate.html('');
                        pay_rate.append(
                            '<table class="table table-striped table-centered table-sm table-bordered  student-table-index">' +
                            '<thead class="thead-dark">' +
                            '<tr>' +
                            '<th class=" col-1 ">#</th>' +
                            '<th class=" col-1 ">Roles</th>' +
                            '<th class=" col-1 text-center">Pay rate</th>' +
                            '<th class=" col-1 text-center">Change</th>' +
                            '</tr>' +
                            '</thead>' +
                            '<tbody>')
                        $.each(response, function(index, value) {
                            pay_rate.append('<tr>' +
                                '<form id="form-payRate-change" method="post">' +
                                '<td class=" col-1 text-danger">' +
                                '<div class =" form-group ">' + (index + 1) + '</div>' +
                                '</td>' +
                                '<td class="col-1">' +
                                '<div class="role-name  form-group">' +
                                value.role_name +
                                '</div>' +
                                '<label class="role-name-inp d-none">' +
                                '<input type="text" name="role_id" class="form-control " value="' +
                                value.role_id + '">' +
                                '</label>' +
                                '</td>' +
                                '<td class="col-1">' +
                                '<div class="pay-rate text-center">' +
                                value.pay_rate_money +
                                '</div>' +
                                '<label class="pay-rate-inp d-none">' +
                                '<input type="text" name="pay_rate" class="form-control " value="' +
                                value.pay_rate + '">' +
                                '</label>' +
                                '</td>' +
                                '<td class="col-1 ">' +
                                '<div align="center" class="">' +
                                '<button type="button" class="btn btn-primary btn-change">' +
                                'Change' +
                                '</button>' +
                                '<button type="button" class="btn btn-primary btn-save d-none"  data-pay_rate="' +
                                value.pay_rate + '" data-dept_id ="' + value.dept_id +
                                '" data-role_id ="' + value.role_id + '">' +
                                'Save' +
                                '</button>' +
                                '</div>' +
                                '</td>' +
                                '</form>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>')
                        });
                        change();
                    }
                });
            }
            var fines_view = '';

            $(".pay-rate-view").on('click', function(){
                $('.title-name').text(' > Pay Rate');
                $(".fines-view").removeClass('bg-dark text-white');
                $(".pay-rate-view").addClass('bg-dark text-white');
                $(".dept").removeClass('d-none');
                $(".fines").addClass('d-none');
            });
            $(".fines-view").on('click',function(){
                $('.title-name').text(' > Fines');
                $(".fines-view").addClass('bg-dark text-white');
                $(".pay-rate-view").removeClass('bg-dark text-white');
                $(".dept").addClass('d-none');
                $(".fines").removeClass('d-none');
                if(fines_view === '') {
                    fine_view();
                }
            });

            function fine_view() {
                fines_view = '1';
                $.ajax({
                    url: "{{ route('ceo.fines_api') }}",
                    type: 'get',
                    dataType: 'JSON',
                    data: '1',
                    success: function(response) {
                        console.log(response);
                            $(".fines-details").html();
                            $(".fines-details").append(
                                '<table class="table">' +
                                '<thead>' +
                                '<th class="col-1">' + '#' +'</th>' +
                                '<th class="col-1">' + 'name' +'</th>' +
                                '<th class="col-1">' + 'fines' +'</th>' +
                                '<th class="col-1">' + 'deduction' +'</th>' +
                                '<th class="col-1">' + 'action' +'</th>' +
                                '</thead>' +
                                '<tbody'
                            );
                        $.each(response, function(index, value){
                            $(".fines-details").append(
                                '<tr class="">' +
                                '<form class="change-fines" method="post" action="">' +
                                '<td class="col-1 text-danger">' +
                                '<div class="form-group">' + (index + 1) +
                                '<input type="hidden" class="inp-fines-id" name="id" value="' + value.id + '" />' +
                                '</div>'  +
                                '</td>' +
                                '<td class="col-1">' +
                                '<div class="form-group fines_name">' +
                                value.name +
                                '</div>' +
                                '<input type="text" class="inp-fines-name d-none" name"name" value="'+ value.name +'"> ' +
                                '</td>' +
                                '<td class="col-1 text-center">' +
                                '<div class="form-group fines_time">' +
                                value.fines_time +
                                '</div>' +
                                '<input type="number" class="inp-fines-time d-none" name"fines" value="'+ value.fines +'"> ' +
                                '</td>' +
                                '<td class="col-1 text-center">' +
                                '<div class="form-group deduction_detail">' +
                                value.deduction_detail +
                                '</div>' +
                                '<input type="text" class="inp-deduction d-none" name"deduction" value="'+ value.deduction +'"> ' +
                                '</td>' +
                                '<td class="col-1 text-center">' +
                                '<div class="form-group">'  +
                                '<button type="button" class="btn btn-change-fines btn-primary">Change</button>'+
                                '<button type="submit" class="btn btn-submit-change-fines btn-primary d-none">Save</button>' +
                                '</div>' +
                                '</td>' +
                                '</form>'+
                                '</tr>'
                            );
                        });
                        $(".fines-details").append(
                            '</tbody>' +
                            '</table>'
                        );
                        change_fines();
                    }
                });
            }

        });

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
        function change_fines(){
            $('.btn-change-fines').click(function(event) {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.btn-submit-change-fines').removeClass('d-none');
                $(this).parents('tr').find('.inp-deduction').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-name').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-time').removeClass('d-none');
                $(this).parents('tr').find('.fines_time').addClass('d-none');
                $(this).parents('tr').find('.fines_name').addClass('d-none');
                $(this).parents('tr').find('.deduction_detail').addClass('d-none');
            });
            $('.btn-submit-change-fines').click(function(event) {
                var this_btn = $(this);
                var id = $(this).parents('tr').find('.inp-fines-id').val();
                var deduction = $(this).parents('tr').find('.inp-deduction').val();
                var name = $(this).parents('tr').find('.inp-fines-name').val();
                var fines = $(this).parents('tr').find('.inp-fines-time').val();
                $.ajax({
                    url: "{{ route('ceo.fines_update') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        id: id,
                        name: name,
                        fines: fines,
                        deduction: deduction,
                    },
                    success: function(response) {
                        console.log(response);
                        this_btn.parents('tr').find('.btn-change-fines').removeClass('d-none');
                        this_btn.addClass('d-none');
                        this_btn.parents('tr').find('.inp-deduction').addClass('d-none');
                        this_btn.parents('tr').find('.inp-fines-name').addClass('d-none');
                        this_btn.parents('tr').find('.inp-fines-time').addClass('d-none');
                        this_btn.parents('tr').find('.fines_time').text(response[0]["fines_time"]);
                        this_btn.parents('tr').find('.fines_name').text(response[0]["name"]);
                        this_btn.parents('tr').find('.deduction_detail').text(response[0]["deduction_detail"]);
                        this_btn.parents('tr').find('.fines_time').removeClass('d-none');
                        this_btn.parents('tr').find('.fines_name').removeClass('d-none');
                        this_btn.parents('tr').find('.deduction_detail').removeClass('d-none');

                    }
                })
            });
        }
    </script>
@endpush
