@extends('layout.master')
@section('content')
    <form action="{{ route('accountants.update', $student->id) }}" method="post">
        @csrf
        @method('put')
        First Name
        <label>
            <input type="text" name="first_name" value="{{ $student->first_name }}">
        </label>
        <br>
        Last Name
        <label>
            <input type="text" name="last_name" value="{{ $student->last_name }}">
        </label>
        <br>
        Gender
        <label>
            <input type="radio" name="gender" value="1" {{ ($student->gender == 1 ? "checked": "") }}>
        </label>Male
        <label>
            <input type="radio" name="gender" value="0" {{ ($student->gender == 0 ? "checked": "") }}>
        </label>Female
        <br>
        DoB
        <label>
            <input type="date" name="dob" value="{{ $student->dob }}">
        </label>
        <br>
        Course
        <label>
            <input type="radio" name="course" value="IT" {{ ($student->course === 'IT' ? "checked": "") }}>
        </label>IT
        <label>
            <input type="radio" name="course" value="Business" {{ ($student->course === "Business" ? "checked": "") }}>
        </label>Business
        <br>
        <button>Submit</button>
    </form>
@endsection