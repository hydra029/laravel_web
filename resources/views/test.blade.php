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
    <div class="col-12">
        <div id="calendar"></div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/main.min.js' )}}"></script>
    <!--suppress JSJQueryEfficiency -->
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
                nowIndicator: true,
                initialView: 'dayGridWeek',
                weekNumbers: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                selectable: true,
                backgroundColor: '#ffffff',
                height: 750,
                contentHeight: 100,
                dayMaxEvents: true,
                eventOrderStrict: true,
                progressiveEventRendering: true,
                eventOrder: "-id",
                customButtons: {
                    today: {
                        text: 'Today',
                        click: function () {
                            del();
                            let date = new Date();
                            calendar.gotoDate(date);
                            loadAttendance(date)
                            emp();
                        }
                    },
                    goto: {
                        text: 'Go to',
                        click: function () {
                            del()
                            let year = $('#sl-1').children(':selected').val();
                            let month = $('#sl-2').children(':selected').val();
                            let day = $('#sl-3').children(':selected').val();
                            let date = new Date(Date.UTC(year, month - 1, day));
                            calendar.gotoDate(date);
                            emp();
                            let d = Date.prototype.getDay(date)
                            loadAttendance(new Date(date.setDate(d + 7)))
                        }
                    },
                    prevYear: {
                        click: function () {
                            del()
                            calendar.prevYear();
                            emp();
                        }
                    },
                    nextYear: {
                        click: function () {
                            del()
                            calendar.nextYear();
                            emp();
                        }
                    },
                    prev: {
                        click: function () {
                            del()
                            calendar.prev();
                            emp();
                        }
                    },
                    next: {
                        click: function () {
                            del()
                            calendar.next();
                            emp();
                        }
                    },
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.background) {
                        info.el.style.background = info.event.extendedProps.background;
                    }
                }
            });
            calendar.render();
            emp();
            loadAttendance(new Date());

            function loadAttendance(d) {
                $.ajax({
                    url: '{{route('api')}}',
                    type: 'POST',
                    dataType: 'json',
                })
                    .done(function (response) {
                        let m = getMon(d);
                        let s = getSun(d);
                        let emp_num = response.length;
                        let emp_id = 0;
                        let num = 9998;
                        for (let i = 0; i < emp_num; i++) {
                            let length = response[i]['attendance'].length;
                            let eventSource = [];
                            for (let j = 0; j < length; j++) {
                                let date = response[i]['attendance'][j]['date'];
                                date = new Date(date);
                                if (s.getTime() >= date.getTime() && m.getTime() <= date.getTime()) {
                                    let emp_name = response[i]['fname'] + " " + response[i]['lname'];
                                    num--;
                                    let shift = response[i]['attendance'][j]['shift'];
                                    let title = 'Shift ' + shift + ': Not Checked Yet';
                                    let color = 'linear-gradient(to right, #ff5b5b 50%, #10c469 50%)';
                                    // let color = '#ff5b5b';
                                    if (response[i]['attendance'][j]['check_in'] === 1) {
                                        title = 'Shift ' + shift + ': Checked In'
                                        color = '#35b8e0';
                                        if (response[i]['attendance'][j]['check_out'] === 1) {
                                            title = 'Shift ' + shift + ': Checked Out';
                                            color = '#10c469';
                                        }
                                    }
                                    let event = {
                                        id: num,
                                        title: title,
                                        start: date,
                                        allDay: true,
                                        overlap: false,
                                        background: color,
                                    }
                                    eventSource.push(event);
                                    if (emp_id !== response[i]['id']) {
                                        emp_id = response[i]['id'];
                                        $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child').append($('<div>')
                                            .attr('style', 'height: 82px; padding: 22px 0')
                                            .addClass('text-center')
                                            .append($('<b>')
                                                .append($('<p>')
                                                    .addClass('emp-name text-center')
                                                    .attr('style', 'font-size: 15px')
                                                    .text(emp_name)
                                                )
                                            )
                                        )
                                    }
                                }

                            }
                            calendar.addEventSource(eventSource);
                        }
                    })
            }

            $(".fc-goto-button")
                .after($('<select>').attr('id', 'sl-3').append($('<option>').text('Day')))
                .after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')));
            let crYear = new Date().getFullYear();
            for (let i = crYear; i >= 2000; i--) {
                $("#sl-1")
                    .append($('<option>')
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
            $("#sl-2").change(function () {
                loadDay();
            })
            $("#sl-1").change(function () {
                loadDay();
            })


            function del() {
                $('table.fc-scrollgrid-sync-table tbody tr > :first-child').remove();
                $('table.fc-col-header  thead tr:first-child > :first-child').remove();
            }

            function emp() {
                $('table.fc-col-header  > thead > tr:first-child')
                    .prepend($('<th>')
                        .attr('role', 'columnheader')
                        .addClass('fc-col-header-cell fc-day')
                        .append($('<div>')
                            .text('Employee')
                        )
                    );
                $('table.fc-scrollgrid-sync-table tbody tr')
                    .prepend($('<td>')
                        .addClass('fc-grid-day fc-day emp_td')
                        .attr('role', 'gridcell')
                        .append($('<div>')
                            .addClass('fc-daygrid-day-frame fc-scrollgrid-sync-inner')
                            .attr('id', 'emp_name_col')
                            .append($('<h5>')
                                .addClass('text-center m-0 p-1')
                                .attr({
                                    style: 'height: 25px; font-style: italic; background-color: #F0F8FF;',
                                    id: 'emp_name'
                                })
                                .text('Name')
                            )
                        )
                    );

            }

            function getDays(y, m) {
                return new Date(y, m, 0).getDate()
            }

            function loadDay() {
                $('#sl-3').empty();
                $('#sl-3').append($('<option>').text('Day'));
                let y = $('#sl-1').children(':selected').val();
                let m = $('#sl-2').children(':selected').val();
                let d = getDays(y, m);
                for (let i = d; i >= 1; i--) {
                    $("#sl-3").append($('<option>')
                        .attr('value', i)
                        .text(i)
                        .addClass('d-opt')
                    )
                }
            }

            function getSun(d) {
                d = new Date(d);
                let day = d.getDay(),
                    diff = d.getDate() - day + 7;
                return new Date(d.setDate(diff));
            }

            function getMon(d) {
                d = new Date(d);
                let day = d.getDay(),
                    diff = d.getDate() - day + (day === 0 ? -6 : 1);
                return new Date(d.setDate(diff));
            }
        });
    </script>
@endpush