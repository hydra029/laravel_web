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
    <a class="btn btn-info btn-primary" href="{{ route('accountants.create') }}">
        Add more
    </a>

    <table class="table table-striped table-centered mb-0" id="student-table-index">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Course</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
    </table>
@endsection
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.js"></script>
    <script type="text/javascript" charset="utf-8"
            src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        $(function () {
            const buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            $('#student-table-index').DataTable({
                dom:
                    "<'row'<'col-md-10'B><'col-sm-2'l>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-8'i><'col-sm-4'p>>",
                select: true,
                processing: true,
                serverSide: true,
                buttons: [
                    $.extend(true, {}, buttonCommon, {
                        extend: 'copyHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'excelHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'pdfHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'csvHtml5'
                    }),
                    $.extend(true, {}, buttonCommon, {
                        extend: 'print'
                    }),
                ],
                columnDefs: [{
                    className: "not-export",
                    targets: [3, 4],
                }],
                ajax: '{!! route('accountants.api') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'gender', name: 'gender'},
                    {data: 'age', name: 'age'},
                    {data: 'course', name: 'course'},
                    {
                        data: 'edit',
                        "targets": 5,
                        "searchable": false,
                        "orderable": false,
                        "render": function (data) {
                            return `<a class='btn btn-primary' href="${data}">Edit</a>`;
                        },
                    },
                    {
                        data: 'delete',
                        "targets": 6,
                        "searchable": false,
                        "orderable": false,
                        "render": function (data) {
                            return `<form action="${data}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                    </form>`;
                        },
                    },

                ]
            });
        });
    </script>
@endpush