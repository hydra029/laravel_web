@extends('layout.master')
@include('employees.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
    <style>
        .fc-daygrid-event {
            margin: 0;
        }
        #calendar .fc-prev-button,#calendar .fc-next-button,#calendar .fc-prevYear-button,#calendar .fc-nextYear-button {
            background-color: #b1d583 !important;
            border: 1px solid #FFF !important
        }
        #calendar .fc-day-today {
            background: #FFFAF0 !important
        }
    </style>
@endpush
@section('content')
    <div id="calendar"></div>
@endsection
@push('js')
    <script src="{{ asset('js/main.min.js' )}}"></script>
    <script>
        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const calendarEl = document.getElementById('calendar');
            let today = new Date();
            const calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'today',
                    center: 'title',
                    right: 'prevYear,prev,next,nextYear',
                },
                initialDate: today,
                navLinks: true, // can click day/week names to navigate views
                nowIndicator: true,
                weekNumbers: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                selectable: true,
                backgroundColor: '#ffffff',
                height: 950,
                contentHeight: 100,
                dayMaxEvents: true, // allow "more" link when too many events
                // customButtons: {
                //     prev: {
                //         text: 'add event...',
                //         click: function() {
                //             let dateStr = prompt('Enter a date in YYYY-MM-DD format');
                //             let date = new Date(dateStr + 'T00:00:00'); // will be in local time
                //
                //             if (!isNaN(date.valueOf())) { // valid?
                //                 calendar.addEvent({
                //                     title: 'dynamic event',
                //                     start: date,
                //                     allDay: true
                //                 });
                //                 alert('Great. Now, update your database...');
                //             } else {
                //                 alert('Invalid date.');
                //             }
                //         }
                //     }
                // }
            });
            calendar.render();

            $.ajax({
                url: '{{route('api')}}',
                type: 'POST',
                dataType: 'json',
            })
                .done(function (response) {
                    let length = response['attendance'].length;
                    for (let i = 0; i < length; i++) {
                        let title = 'Not Checked Yet';
                        let color = '#ff5b5b';
                        let date = response['attendance'][i]['date'];
                        if (response['attendance'][i]['check_in'] === 1) {
                            title = 'Checked In'
                            color = '#35b8e0';
                            if (response['attendance'][i]['check_out'] === 1) {
                                title = 'Checked Out';
                                color = '#10c469';
                            }
                        }
                        calendar.addEvent({
                            title: title,
                            start: date,
                            allDay: true,
                            overlap: false,
                            rendering: 'background',
                            color: color,
                        });
                    }

                })
            // $('#calendar .fc-day-today').attr('style', 'background: #FFF !important');
            // $('#calendar .fc-button-primary').attr('style', 'border: none !important');
            // $('#calendar .fc-prev-button, .fc-next-button, .fc-prevYear-button, .fc-nextYear-button').attr('style','background-color: #b1d583 !important')
        });


    </script>
@endpush