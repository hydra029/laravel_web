@extends('layout.master')
@include('accountants.menu')
@section('content')
    <table class="table table-striped table-centered mb-0" id="table-index">
        <thead>
        <tr>
            <th>Shift</th>
            <th>Status</th>
            <th>Check In</th>
            <th>Check Out</th>
        </tr>
        </thead>

        @foreach($data as $each)
            <tr>
                <td class="col-3">
                    {{$each->shift_name}}
                </td>
                <td class="col-3">
                    {{$each->shift_status}}
                </td>
                @switch($each->shifts->status)
                    @case(1)
                        <td>
                            <button class="btn btn-outline-primary"
                                    disabled="disabled"> Check
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-outline-primary"
                                    disabled="disabled"> Check
                            </button>
                        </td>
                        @break
                    @case(2)
                        @if($each->check_in_time === "00:00")
                            <td>
                                <form action="{{ route('accountants.checkin') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="shift" value="{{ $each->shifts->id }}"/>
                                    <button class="btn btn-primary"> Check</button>
                                </form>
                            </td>
                        @else
                            <td>
                                <button class="btn btn-success" disabled="disabled">{{$each->check_in_time}} </button>
                            </td>
                        @endif
                        @if($each->check_out_time === "00:00")
                            <td>
                                <form action="{{ route('accountants.checkout') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="shift" value="{{ $each->shifts->id }}"/>
                                    <button class="btn btn-primary"> Check</button>
                                </form>
                            </td>
                        @else
                            <td>
                                <button class="btn btn-success" disabled="disabled"> {{$each->check_out_time}} </button>
                            </td>
                        @endif
                        @break
                    @case(3)
                        <td>
                            <button class="btn btn-secondary" disabled="disabled"> {{$each->check_in_time}} </button>
                        </td>
                        <td>
                            <button class="btn btn-secondary" disabled="disabled"> {{$each->check_out_time}} </button>
                        </td>
                        @break
                @endswitch
            </tr>
        @endforeach
    </table>
@endsection
@push('js')
@endpush
