@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
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
            <th colspan="2">Check In</th>
            <th colspan="2">Check Out</th>
            <th rowspan="2">Change</th>
        </tr>
        <tr>
            <th>Start</th>
            <th>End</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>
        @foreach($time as $each)
            <tr>
                <form id="form-time-change" method="post">
                    <td class="col-2">
                        <div class="shift-name">
                            {{$each -> shift_name}}
                        </div>
                        <label class="shift-name-inp d-none">
                            <input type="text" name="name" class="form-control text-center"
                                   value="{{$each -> shift_name}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="shift-status">
                            {{$each -> shift_status}}
                        </div>
                        <label class="shift-status-inp d-none">
                            <input type="text" name="status" class="form-control text-center"
                                   value="{{$each -> shift_status}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="shift-in-start">
                            {{$each -> in_start}}
                        </div>
                        <label class="shift-in-start-inp d-none">
                            <input type="text" name="in_start" class="form-control text-center"
                                   value="{{$each -> in_start}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="shift-in-end">
                            {{$each -> in_end}}
                        </div>
                        <label class="shift-in-end-inp d-none">
                            <input type="text" name="in_end" class="form-control text-center"
                                   value="{{$each -> in_end}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="shift-out-start">
                            {{$each -> out_start}}
                        </div>
                        <label class="shift-out-start-inp d-none">
                            <input type="text" name="out_start" class="form-control text-center"
                                   value="{{$each -> out_start}}">
                        </label>
                    </td>
                    <td class="col-2">
                        <div class="shift-out-end">
                            {{$each -> out_end}}
                        </div>
                        <label class="shift-out-end-inp d-none">
                            <input type="text" name="out_end" class="form-control text-center"
                                   value="{{$each -> out_end}}">
                        </label>
                    </td>
                    <td class="col-2">
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
    </table>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-change').click(function (event) {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.btn-save').removeClass('d-none');
                $(this).parents('tr').find('.shift-name-inp').removeClass('d-none');
                $(this).parents('tr').find('.shift-name').addClass('d-none');
                $(this).parents('tr').find('.shift-in-start-inp').removeClass('d-none');
                $(this).parents('tr').find('.shift-in-start').addClass('d-none');
                $(this).parents('tr').find('.shift-in-end-inp').removeClass('d-none');
                $(this).parents('tr').find('.shift-in-end').addClass('d-none');
                $(this).parents('tr').find('.shift-out-start-inp').removeClass('d-none');
                $(this).parents('tr').find('.shift-out-start').addClass('d-none');
                $(this).parents('tr').find('.shift-out-end-inp').removeClass('d-none');
                $(this).parents('tr').find('.shift-out-end').addClass('d-none');
            });
            $('.btn-save').click(function (event) {
                let tr = $(this).parents('tr');
                let form = tr.find('form');
                const time_regex = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/;
                let in_start_inp = tr.find('.shift-in-start-inp').val();
                let in_end_inp = tr.find('.shift-in-end-inp').text();
                let out_start_inp = tr.find('.shift-out-start-inp').text();
                let out_end_inp = tr.find('.shift-out-end-inp').text();
                let text = in_start_inp.concat(" ", in_end_inp).concat(" ", out_start_inp).concat(" ", out_end_inp);

                console.log(in_start_inp);
                if (text.match(time_regex)) {
                    console.log('success');
                }

                $.ajax({
                    url: "{{ route('ceo.time_change') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: form.serializeArray(),
                })
                    .done(function (response) {
                        tr.find('.btn-change').removeClass('d-none');
                        tr.find('.btn-save').addClass('d-none');
                        tr.find('.shift-name-inp').addClass('d-none');
                        tr.find('.shift-name').removeClass('d-none');
                        tr.find('.shift-in-start-inp').addClass('d-none');
                        tr.find('.shift-in-start').removeClass('d-none');
                        tr.find('.shift-in-end-inp').addClass('d-none');
                        tr.find('.shift-in-end').removeClass('d-none');
                        tr.find('.shift-out-start-inp').addClass('d-none');
                        tr.find('.shift-out-start').removeClass('d-none');
                        tr.find('.shift-out-end-inp').addClass('d-none');
                        tr.find('.shift-out-end').removeClass('d-none');
                        tr.find('.shift-in-start').text(response[0]["check_in_start"].slice(0, 5));
                        tr.find('.shift-in-end').text(response[0]["check_in_end"].slice(0, 5));
                        tr.find('.shift-out-start').text(response[0]["check_out_start"].slice(0, 5));
                        tr.find('.shift-out-end').text(response[0]["check_out_end"].slice(0, 5));
                        $.notify('Action completed', 'success');
                    })
                    .fail(function () {
                        $.notify('Format Input Error', 'error');
                    })
            });

        });
    </script>
@endpush