@extends('layout.master')
@include('accountants.menu')
@section('content')
    <table id="tableSalary" class="table table-striped table-bordered table-sm">
        <thead>
            <tr>
                <th class="th-sm">
                    Name
                </th>
                <th class="th-sm">
                    Department
                </th>
                <th class="th-sm">
                    Role
                </th>
                <th class="th-sm">
                    Work day
                </th>
                <th class="th-sm">
                    Fines
                </th>
                <th class="th-sm">
                    Deduction
                </th>
                <th class="th-sm">
                    Salary
                </th>
                <th class="th-sm">
                    Accountant confirm
                </th>
                <th class="th-sm">
                    Ceo confirm
                </th>
            </tr>
        </thead>
        <tbody></tbody>
        </table>
@endsection
