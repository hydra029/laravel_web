@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .div-change-page{
                width: 200px;
                top: -40px
            }
            .div-change-page .change-page {
                background-color: rgb(234, 226, 226);
                width: 100px;
                margin-bottom: 10px;
                border:1px rgb(242, 199, 199) solid;
                cursor: pointer;
            }
            .div-change-page .change-page span {
                line-height:30px
            }
        </style>
    @endpush
    <div class="position-absolute div-change-page"	>
        <table class="table col-12">
            <tr class="text-center">
                <td class="p-0">
                    <div class="change-page bg-dark text-white">
                        <span>Pay rate</span>
                    </div>
                </td>
                <td class="p-0">
                    <div class="change-page">
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
    <div class="sumo suma">
    </div>
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
    </table>

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
                                '<td class=" col-1 ">' +
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
                                value.pay_rate +
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
                        tr.find('.pay-rate').text(response[0]["pay_rate"]);
                        $.notify('Action completed', 'success');
                    }
                })

            });
        }
    </script>
@endpush
