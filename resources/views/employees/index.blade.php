@extends('layout.master')
@include('employees.menu')
@section('content')
    <form action="{{ route('employees.store') }}" method="post">
        @csrf

        <br>
        <button class="btn btn-primary">Submit</button>
    </form>
    <table class="table table-striped table-centered mb-0" id="table-index">
        <thead>
        <tr>
            <th>Date</th>
            <th>Shift</th>
            <th>Status</th>
            <th>Check In</th>
            <th>Check Out</th>
        </tr>
        </thead>

        @foreach($data as $each)
            <tr>
                <td class="col-4">
                    {{$each->date}}
                </td>
            </tr>
        @endforeach
    </table>

@endsection
@push('js')

@endpush