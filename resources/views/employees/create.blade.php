@extends('layout.master')
@section('content')
    <form action="{{ route('employees.store') }}" method="post">
        @csrf
        Name
        <label>
            <input type="text" name="name">
        </label>

        @if ($errors->has('name'))
            <span>
          {{ $errors->first('name') }}
        </span>
        @endif
        <br>
        <button>Submit</button>
    </form>
@endsection