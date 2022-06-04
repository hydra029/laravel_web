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
                <td>
                    {{$each -> shift_name}}
                </td>
                <td>
                    {{$each -> shift_status}}
                </td>
                <td>
                    {{$each -> check_in_start}}
                </td>
                <td>
                    {{$each -> check_in_end}}
                </td>
                <td>
                    {{$each -> check_out_start}}
                </td>
                <td>
                    {{$each -> check_out_end}}
                </td>
            </tr>
        @endforeach
    </table>
@endsection
@push('js')

@endpush