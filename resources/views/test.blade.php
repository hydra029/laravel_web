@extends('layout.master')
@include('employees.menu')
@section('content')
    <form action="{{ route('employees.store') }}" method="post">
        @csrf
        <button class="btn btn-secondary"> Add</button>
    </form>
    <table class="table table-striped table-centered mb-0" id="table-index">
        <thead>
        <tr>
            <th>Name</th>
            <th>Gender</th>
            <th>Birth date</th>
            <th>Status</th>
            <th>Roles name</th>
            <th>Departments name</th>
        </tr>
        </thead>
        @foreach($data as $each)
        <tr>
            <td>{{ $each->full_name }}</td>
            <td>{{ $each->gender_name }}</td>
            <td>{{ $each->date_of_birth }}</td>
            <td>{{ $each->status }}</td>
            <td>{{ $each->roles->name }}</td>
            <td>{{ $each->departments->name }}</td>
        </tr>
        @endforeach
        {{ $data->links() }}
{{--        @foreach($data as $each)--}}
{{--            <tr>--}}
{{--                <td class="col-3">--}}
{{--                    {{$each->shift_name}}--}}
{{--                </td>--}}
{{--                <td class="col-3">--}}
{{--                    {{$each->shift_status}}--}}
{{--                </td>--}}
{{--                @switch($each->status)--}}
{{--                    @case(1)--}}
{{--                        <td>--}}
{{--                            <button class="btn btn-outline-primary"--}}
{{--                                    disabled="disabled"> {{$each->check_in_status}}</button>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <button class="btn btn-outline-primary"--}}
{{--                                    disabled="disabled"> {{$each->check_out_status}}</button>--}}
{{--                        </td>--}}
{{--                        @break--}}
{{--                    @case(2)--}}
{{--                        @switch($each->check_in)--}}
{{--                            @case(0)--}}
{{--                                <td>--}}
{{--                                    <form action="{{ route('employees.checkin') }}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        @method('PUT')--}}
{{--                                        <button class="btn btn-primary"> {{$each->check_in_status}}</button>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
{{--                                @break--}}
{{--                            @case(1)--}}
{{--                                <td>--}}
{{--                                    <button class="btn btn-success"> {{$each->check_in_status}}</button>--}}
{{--                                </td>--}}
{{--                                @break--}}
{{--                        @endswitch--}}
{{--                        @switch($each->check_out)--}}
{{--                            @case(0)--}}
{{--                                <td>--}}
{{--                                    <form action="{{ route('employees.checkout') }}" method="post">--}}
{{--                                        @csrf--}}
{{--                                        @method('PUT')--}}
{{--                                        <button class="btn btn-primary"> {{$each->check_out_status}}</button>--}}
{{--                                    </form>--}}
{{--                                </td>--}}
{{--                                @break--}}
{{--                            @case(1)--}}
{{--                                <td>--}}
{{--                                    <button class="btn btn-success"> {{$each->check_out_status}}</button>--}}
{{--                                </td>--}}
{{--                                @break--}}
{{--                        @endswitch--}}
{{--                        @break--}}
{{--                    @case(3)--}}
{{--                        <td>--}}
{{--                            <button class="btn btn-secondary" disabled="disabled"> {{$each->check_in_status}}</button>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <button class="btn btn-secondary" disabled="disabled"> {{$each->check_out_status}}</button>--}}
{{--                        </td>--}}
{{--                        @break--}}

{{--                @endswitch--}}
{{--            </tr>--}}
{{--        @endforeach--}}
    </table>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#home').attr('style', 'color: #3d73dd!important');
        });
    </script>
@endpush
