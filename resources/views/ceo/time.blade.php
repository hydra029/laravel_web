@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <style type="text/css">
            td {
                height: 100px;
            }
        </style>
        <link rel="stylesheet" type="text/css"
              href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css"/>
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
    <table class="table table-striped table-centered mb-20 table-bordered text-center" id="student-table-index">
        <thead>
        <tr>
            <th rowspan="2">Shift</th>
            <th rowspan="2">Status</th>
            <th colspan="4">Check In</th>
            <th colspan="4">Check Out</th>
            <th rowspan="2">Change</th>
        </tr>
        <tr>
            <th>Start</th>
            <th>End</th>
            <th>Late 1</th>
            <th>Late 2</th>
            <th>Early 1</th>
            <th>Early 2</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>
        <tbody>
        @foreach($time as $each)
            <tr>
                <form class="form-time-change" method="post">
                    <td>
                        <div class="shift-name">
                            {{$each -> shift_name}}
                        </div>
                        <label class="shift-name-inp d-none">
                            <input type="text" name="name" class="form-control text-center"
                                   value="{{$each -> shift_name}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-status">
                            {{$each -> shift_status}}
                        </div>
                        <label class="shift-status-inp d-none">
                            <input type="text" name="status" class="form-control text-center"
                                   value="{{$each -> shift_status}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-in-start">
                            {{$each -> in_start}}
                        </div>
                        <label class="shift-in-start-inp d-none">
                            <input type="text" name="in_start" class="form-control text-center"
                                   value="{{$each -> in_start}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-in-end">
                            {{$each -> in_end}}
                        </div>
                        <label class="shift-in-end-inp d-none">
                            <input type="text" name="in_end" class="form-control text-center"
                                   value="{{$each -> in_end}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-in-late-1">
                            {{$each -> in_late_1}}
                        </div>
                        <label class="shift-in-late-1-inp d-none">
                            <input type="text" name="in_late_1" class="form-control text-center"
                                   value="{{$each -> in_late_1}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-in-late-2">
                            {{$each -> in_late_2}}
                        </div>
                        <label class="shift-in-late-2-inp d-none">
                            <input type="text" name="in_late_2" class="form-control text-center"
                                   value="{{$each -> in_late_2}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-out-early-1">
                            {{$each -> out_early_1}}
                        </div>
                        <label class="shift-out-early-1-inp d-none">
                            <input type="text" name="out_early_1" class="form-control text-center"
                                   value="{{$each -> out_early_1}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-out-early-2">
                            {{$each -> out_early_2}}
                        </div>
                        <label class="shift-out-early-2-inp d-none">
                            <input type="text" name="out_early_2" class="form-control text-center"
                                   value="{{$each -> out_early_2}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-out-start">
                            {{$each -> out_start}}
                        </div>
                        <label class="shift-out-start-inp d-none">
                            <input type="text" name="out_start" class="form-control text-center"
                                   value="{{$each -> out_start}}">
                        </label>
                    </td>
                    <td>
                        <div class="shift-out-end">
                            {{$each -> out_end}}
                        </div>
                        <label class="shift-out-end-inp d-none">
                            <input type="text" name="out_end" class="form-control text-center"
                                   value="{{$each -> out_end}}">
                        </label>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-change">
                            Change
                        </button>
                        <button type="button" class="btn btn-primary btn-save d-none" data-id="{{$each->id}}">
                            Save
                        </button>
                    </td>
                </form>
            </tr>
        @endforeach
        </tbody>
        @if($count < 3)
            <tr class="hidden-form d-none">
                <form id="form-time-save" method="post">
                    <input type="hidden" name="status" value="1">
                    <td>
                        <label class="shift-name-inp">
                            <select name="id">
                                @foreach($shifts as $shift_name => $shift_id)
                                    <option value="{{$shift_id}}" @if($shift_id === 1)selected="selected"@endif>
                                        {{$shift_name}}
                                    </option>
                            @endforeach
                        </label>
                    </td>
                    <td>
                        <div>
                            Inactive
                        </div>
                    </td>
                    <td>
                        <label class="shift-in-start-inp">
                            <input type="text" name="in_start" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-in-end-inp">
                            <input type="text" name="in_end" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-in-late-1-inp">
                            <input type="text" name="in_late_1" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-in-late-2-inp">
                            <input type="text" name="in_late_2" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-out-early-1-inp">
                            <input type="text" name="out_early_1" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-out-early-2-inp">
                            <input type="text" name="out_early_2" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-out-start-inp">
                            <input type="text" name="out_start" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <label class="shift-out-end-inp">
                            <input type="text" name="out_end" class="form-control text-center">
                        </label>
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-new">
                            Save
                        </button>
                    </td>
                </form>
            </tr>
            <tr>
                <td colspan="12">
                    <button id="add_more" type="button">
                        Add more
                    </button>
                </td>
            </tr>
        @endif
    </table>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('td').attr('class', 'col-1');
            $('label').addClass('mb-0');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-change').click(function (event) {
                $(this).addClass('d-none');
                $(this).parents('tr')
                    .find('.btn-save, .shift-in-start-inp, .shift-in-end-inp, .shift-in-late-1-inp, .shift-in-late-2-inp, .shift-out-early-1-inp, .shift-out-early-2-inp, .shift-out-start-inp, .shift-out-end-inp')
                    .removeClass('d-none');
                $(this).parents('tr')
                    .find('.shift-in-start, .shift-in-end, .shift-in-late-1, .shift-in-late-2, .shift-out-early-1, .shift-out-early-2, .shift-out-start, .shift-out-end')
                    .addClass('d-none');

            });
            $('.btn-save').click(function (event) {
                let tr = $(this).parents('tr');
                let form = tr.find('form');
                const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d)$/;
                let in_start_inp = tr.find('.shift-in-start-inp').find('input').val();
                let in_end_inp = tr.find('.shift-in-end-inp').find('input').val();
                let in_late_1_inp = tr.find('.shift-in-late-1-inp').find('input').val();
                let in_late_2_inp = tr.find('.shift-in-late-2-inp').find('input').val();
                let out_early_1_inp = tr.find('.shift-out-early-1-inp').find('input').val();
                let out_early_2_inp = tr.find('.shift-out-early-2-inp').find('input').val();
                let out_start_inp = tr.find('.shift-out-start-inp').find('input').val();
                let out_end_inp = tr.find('.shift-out-end-inp').find('input').val();
                let text = in_start_inp.concat(" ", in_end_inp).concat(" ", in_late_1_inp).concat(" ", in_late_2_inp).concat(" ", out_early_1_inp).concat(" ", out_early_2_inp).concat(" ", out_start_inp).concat(" ", out_end_inp);
                if (text.match(time_regex)) {
                    $.ajax({
                        url: "{{ route('ceo.time_change') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serializeArray(),
                    })
                        .done(function (response) {
                            tr.find('.btn-change, .shift-name, .shift-in-start, .shift-in-end, .shift-in-late-1, .shift-in-late-2, .shift-out-early-1, .shift-out-early-2, .shift-out-start, .shift-out-end')
                                .removeClass('d-none');
                            tr.find('.btn-save, .shift-in-start-inp, .shift-in-end-inp, .shift-in-late-1-inp, .shift-in-late-2-inp, .shift-out-early-1-inp, .shift-out-early-2-inp, .shift-out-start-inp, .shift-out-end-inp')
                                .addClass('d-none');
                            tr.find('.shift-in-start').text(response[0]["check_in_start"].slice(0, 5));
                            tr.find('.shift-in-end').text(response[0]["check_in_end"].slice(0, 5));
                            tr.find('.shift-in-late-1').text(response[0]["check_in_late_1"].slice(0, 5));
                            tr.find('.shift-in-late-2').text(response[0]["check_in_late_2"].slice(0, 5));
                            tr.find('.shift-out-early-1').text(response[0]["check_out_early_1"].slice(0, 5));
                            tr.find('.shift-out-early-2').text(response[0]["check_out_early_2"].slice(0, 5));
                            tr.find('.shift-out-start').text(response[0]["check_out_start"].slice(0, 5));
                            tr.find('.shift-out-end').text(response[0]["check_out_end"].slice(0, 5));
                            $.notify('Action completed', 'success');
                        })
                        .fail(function () {
                            $.notify('Input Format Error', 'error');
                        })
                } else {
                    $.notify('Input Format Error', 'error');
                }
            });
            $('#add_more').click(function (event) {
                $('.hidden-form').removeClass('d-none')
                $('#add_more').find('tr').addClass('d-none')
            });
            $('.btn-new').click(function (event) {
                let tr = $(this).parents('tr');
                let form = tr.find('form');
                const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d) ([0-1]\d|2[0-3]):([0-5]\d)$/;
                let in_start_inp = tr.find('.shift-in-start-inp').find('input').val();
                let in_end_inp = tr.find('.shift-in-end-inp').find('input').val();
                let in_late_1_inp = tr.find('.shift-in-late-1-inp').find('input').val();
                let in_late_2_inp = tr.find('.shift-in-late-2-inp').find('input').val();
                let out_early_1_inp = tr.find('.shift-out-early-1-inp').find('input').val();
                let out_early_2_inp = tr.find('.shift-out-early-2-inp').find('input').val();
                let out_start_inp = tr.find('.shift-out-start-inp').find('input').val();
                let out_end_inp = tr.find('.shift-out-end-inp').find('input').val();
                let text = in_start_inp.concat(" ", in_end_inp).concat(" ", in_late_1_inp).concat(" ", in_late_2_inp).concat(" ", out_early_1_inp).concat(" ", out_early_2_inp).concat(" ", out_start_inp).concat(" ", out_end_inp);
                if (text.match(time_regex)) {
                    $.ajax({
                        url: "{{ route('ceo.time_save') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: form.serializeArray(),
                    })
                        .done(function (response) {
                            location.reload();
                        })
                        .fail(function () {
                            $.notify('Input Format Error', 'error');
                        })
                } else {
                    $.notify('Input Format Error', 'error');
                }
            });
        });
    </script>
@endpush