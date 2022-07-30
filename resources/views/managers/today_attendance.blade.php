@extends('layout.master')
@include('managers.menu')
@section('content')
    <table class="table table-striped table-centered table-bordered mb-20 text-center" id="student-table-index">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Role</th>
            @foreach($shifts as $value => $shift)
                <th>
                    {{$value}}
                </th>
            @endforeach
        </tr>
        </thead>
        @foreach($data as $each)
            <tr>
                <td class="col-1">
                    {{$num++}}
                </td>
                <td class="col-2">
                    {{$each -> full_name}}
                </td>
                <td class="col-1">
                    {{$each -> role_name}}
                </td>
                <td class="col-2">
                    {{$each -> check_1}}
                </td>
                <td class="col-2">
                    {{$each -> check_2}}
                </td>
                <td class="col-2">
                    {{$each -> check_3}}
                </td>
            </tr>
        @endforeach
    </table>
    <nav>
        <ul class="pagination pagination-rounded mb-0">
            <li class="page-item">
                {{ $data->links() }}
            </li>
        </ul>
    </nav>
@endsection
@push('js')

@endpush
