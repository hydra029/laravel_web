@extends('layout.master')
@include('employees.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
@endpush
@section('content')
    <div id="calendar"></div>
@endsection
@push('js')
    <script src="{{ asset('js/main.min.js' )}}"></script>
    <script>

        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            let today = new Date();
            const calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today',
                },
                initialDate:  today,
                navLinks: true, // can click day/week names to navigate views
                nowIndicator: true,

                weekNumbers: true,
                weekNumberCalculation: 'ISO',

                editable: true,
                selectable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                events: [
                    {
                        title: 'All Day Event',
                        start: '2019-09-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2020-09-07',
                        end: '2020-09-10'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2020-09-09T16:00:00'
                    },
                    {
                        groupId: 999,
                        title: 'Repeating Event',
                        start: '2020-09-16T16:00:00'
                    },
                    {
                        title: 'Conference',
                        start: '2020-09-11',
                        end: '2020-09-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-09-12T10:30:00',
                        end: '2020-09-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2020-09-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2020-09-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2020-09-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2020-09-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2020-09-13T07:00:00'
                    },

                ]
            });

            calendar.render();
        });
    </script>
@endpush