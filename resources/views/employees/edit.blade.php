@extends('layout.master')
@section('content')
<form action="{{ route('employees.update', $course) }}" method="post">
    @csrf
    @method('put')
    Name
    <label>
        <input type="text" name="name" value="{{ $course->name }}">
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