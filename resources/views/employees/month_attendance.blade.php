@extends('layout.master')
@include('employees.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
    <style>
        .fc-daygrid-event {
            margin: 0;
        }

        #calendar .fc-day-today {
            background: #F8F8FF !important
        }

        #calendar .fc-daygrid-event {
            padding: 2px !important;
        }

        #calendar .fc-header-toolbar {
            margin: 0 !important;
        }

        #calendar .page-title-box {
            height: 60px;
        }

        #calendar .fc-daygrid {
            margin-top: 10px;
        }

        #calendar .fc-daygrid-day-top {
            height: 25px;
        }

        #external-events .fc-event:hover {
            cursor: pointer;
        }

        select {
            margin: 0 1px;
        }

    </style>
@endpush
@section('content')
    <div class="col-2">
        <div id='external-events'>
            <p class="text-center">
                <strong>Detail</strong>
            </p>
            <div class='fc-event fc-h-event fc-daygrid-block-event'>
                <div class='fc-event-main'>My Event 1</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event'>
                <div class='fc-event-main'>My Event 2</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event'>
                <div class='fc-event-main'>My Event 3</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event'>
                <div class='fc-event-main'>My Event 4</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event'>
                <div class='fc-event-main'>My Event 5</div>
            </div>

        </div>
    </div>
    <div class="col-10">
        <div id="calendar"></div>
    </div>
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
                    left: 'today,goto',
                    center: 'title',
                    right: 'prevYear,prev,next,nextYear',
                },
                initialDate: today,
                // navLinks: true,
                nowIndicator: true,
                weekNumbers: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                selectable: true,
                backgroundColor: '#ffffff',
                height: 750,
                contentHeight: 100,
                dayMaxEvents: true,
                initialView: 'dayGridMonth',
                customButtons: {
                    today: {
                        text: 'Today',
                        click: function () {
                            let date = new Date(); // will be in local time
                            calendar.gotoDate(date);
                        }
                    },
                    goto: {
                        text: 'Go to',
                        click: function () {
                            let year = $('#sl-1').children(':selected').val();
                            let month = $('#sl-2').children(':selected').val();
                            let date = new Date(Date.UTC(year, month - 1)); // will be in local time
                            calendar.gotoDate(date);
                        }
                    }
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.background) {
                        info.el.style.background = info.event.extendedProps.background;
                    }
                }
            });
            calendar.render();
            $.ajax({
                url: '{{route('employees.attendance_api')}}',
                type: 'POST',
                dataType: 'json',
            })
                .done(function (response) {
                    let length = response['attendance'].length;
                    for (let i = 0; i < length; i++) {
                        let shift = response['attendance'][i]['shift'];
                        let title = 'Shift ' + shift + ': Not Checked Yet';
                        let color = 'linear-gradient(to right, #ff5b5b 50%, #10c469 50%)';
                        // let color = '#ff5b5b';
                        let date = response['attendance'][i]['date'];
                        if (response['attendance'][i]['check_in'] === 1) {
                            title = 'Shift ' + shift + ': Checked In'
                            color = '#35b8e0';
                            if (response['attendance'][i]['check_out'] === 1) {
                                title = 'Shift ' + shift + ': Checked Out';
                                color = '#10c469';
                            }
                        }
                        calendar.addEvent({
                            title: title,
                            start: date,
                            allDay: true,
                            overlap: false,
                            background: color,
                        });
                    }
                })
            $(".fc-goto-button").after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')));
            let crYear = new Date().getFullYear();
            for (let i = crYear; i >= 2000; i--) {
                $("#sl-1").append($('<option>')
                    .attr('value', i)
                    .text(i)
                    .addClass('y-opt')
                )
            }
            for (let i = 12; i >= 1; i--) {
                $("#sl-2").append($('<option>')
                    .attr('value', i)
                    .text(i)
                    .addClass('m-opt')
                )
            }
        });
    </script>
@endpush