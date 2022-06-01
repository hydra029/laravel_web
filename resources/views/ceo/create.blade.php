@extends('layout.master')
@section('content')
<form action="{{ route('processlogin') }}" method="post">
    @csrf
    Email
    <label>
        <input type="text" name="email" id="email">
    </label>
    <br>
    Last Name
    <label>
        <input type="text" name="last_name">
    </label>
    <br>
    Gender
    <label>
        <input type="radio" name="gender" value="1">
    </label>Male
    <label>
        <input type="radio" name="gender" value="0">
    </label>Female
    <br>
    DoB
    <label>
        <input type="date" name="dob">
    </label>
    <br>
    Course
    <label>
        <input type="radio" name="course" value="IT">
    </label>IT
    <label>
        <input type="radio" name="course" value="Business">
    </label>Business
    <br>
    <button>Submit</button>
</form>
@endsection