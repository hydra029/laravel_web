@extends('layout.master')
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
    <table class="table table-striped table-centered mb-20" id="student-table-index">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Role</th>
            @foreach($shifts as $shift)
                <th>
                    {{$shift}}
                </th>
            @endforeach
        </tr>
        </thead>
        @foreach($data as $each)
            <tr>
                <td>
                    {{$num++}}
                </td>
                <td>
                    {{$each -> full_name}}
                </td>
                <td>
                    {{$each -> role_name}}
                </td>
                <td>
                    {{$each -> check_1}}
                </td>
                <td>
                    {{$each -> check_2}}
                </td>
                <td>
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