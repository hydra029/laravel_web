@extends('layout.master')
@include('managers.menu')
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

        .event-1 {
            background: #9761ed;
        }

        .event-2 {
            background: #8ca5ff
        }

        .event-3 {
            background: #00c67f
        }

        .event-4 {
            background: #f07171
        }

        .event-5 {
            background: #f57542
        }

        .event-6 {
            background: #f03e44
        }

        .emp-name {
            margin: 8px 0;
        }
    </style>
@endpush
@section('content')
    <div class="col-1 p-1">
        <div id='external-events'>
            <p class="text-center">
                <strong>Detail</strong>
            </p>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-1'>
                <div class='fc-event-main tc'>Early Type 1</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-2'>
                <div class='fc-event-main tc'>Early Type 2</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-3'>
                <div class='fc-event-main tc'>On Time</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-4'>
                <div class='fc-event-main tc'>Late Type 1</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-5'>
                <div class='fc-event-main tc'>Late Type 2</div>
            </div>
            <div class='fc-event fc-h-event fc-daygrid-block-event event-6'>
                <div class='fc-event-main tc'>Off Work</div>
            </div>

        </div>
    </div>
    <div class="col-11 p-1">
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
                nowIndicator: true,
                initialView: 'dayGridWeek',
                weekNumbers: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                selectable: true,
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
                            calendar.removeAllEvents();
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
                            calendar.removeAllEvents();
                            del();
                            let year = $('#sl-1').children(':selected').val();
                            let month = $('#sl-2').children(':selected').val();
                            let day = $('#sl-3').children(':selected').val();
                            let date = new Date(Date.UTC(year, month - 1, day));
                            calendar.gotoDate(date);
                            emp();
                            loadAttendance(date);
                        }
                    },
                    prevYear: {
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            calendar.prevYear();
                            emp();
                            let date = calendar.getDate();
                            loadAttendance(date);
                        }
                    },
                    nextYear: {
                        click: function () {
                            calendar.removeAllEvents();
                            del()
                            calendar.nextYear();
                            emp();
                            let date = calendar.getDate();
                            loadAttendance(date);
                        }
                    },
                    prev: {
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            calendar.prev();
                            emp();
                            let date = calendar.getDate();
                            loadAttendance(date);
                        }
                    },
                    next: {
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            calendar.next();
                            emp();
                            let date = calendar.getDate();
                            loadAttendance(date);
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
            loadAttendance(today);

            function loadAttendance(d) {
                let m = getMon(d).toISOString().slice(0, 10);
                let s = getSun(d).toISOString().slice(0, 10);
                $.ajax({
                    url: '{{route('managers.employee_api')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {m: m, s: s},
                })
                    .done(function (response) {
                        let emp_num = response.length - 1;
                        let emp_id = 0;
                        let e_num = 0;
                        let num = 9998;
                        let text_color;
                        for (let i = 0; i < emp_num; i++) {
                            let length = response[i]['attendance'].length;
                            let eventSource = [];
                            for (let j = 0; j < length; j++) {
                                let date = response[i]['attendance'][j]['date'];
                                date = new Date(date);
                                let emp_name = response[i]['fname'] + " " + response[i]['lname'];
                                num--;
                                let check_in = response[i]['attendance'][j]['check_in'].slice(0, 5);
                                let check_out = response[i]['attendance'][j]['check_out'].slice(0, 5);
                                let check_in_start = response[i]['attendance'][j]['shifts']['check_in_start'].slice(0, 5);
                                let check_in_end = response[i]['attendance'][j]['shifts']['check_in_end'].slice(0, 5);
                                let check_in_late_1 = response[i]['attendance'][j]['shifts']['check_in_late_1'].slice(0, 5);
                                let check_in_late_2 = response[i]['attendance'][j]['shifts']['check_in_late_2'].slice(0, 5);
                                let check_out_start = response[i]['attendance'][j]['shifts']['check_out_start'].slice(0, 5);
                                let check_out_end = response[i]['attendance'][j]['shifts']['check_out_end'].slice(0, 5);
                                let check_out_early_1 = response[i]['attendance'][j]['shifts']['check_out_early_1'].slice(0, 5);
                                let check_out_early_2 = response[i]['attendance'][j]['shifts']['check_out_early_2'].slice(0, 5);
                                let title = check_in + Array(10).fill('\xa0').join('') + check_out;
                                let color_1 = '#f03e44';
                                let color_2 = '#f03e44';

                                if (check_in >= check_in_start && check_in <= check_in_end) {
                                    color_1 = '#00c67f';
                                } else if (check_in > check_in_end && check_in <= check_in_late_1) {
                                    color_1 = '#f07171';
                                } else if (check_in > check_in_late_1 && check_in <= check_in_late_2) {
                                    color_1 = '#f57542';
                                }

                                if (check_out >= check_out_start && check_out <= check_out_end) {
                                    color_2 = '#00c67f';
                                } else if (check_out >= check_out_early_1 && check_out < check_out_start) {
                                    color_2 = '#8ca5ff';
                                } else if (check_out >= check_out_early_2 && check_out < check_out_early_1) {
                                    color_2 = '#9761ed';
                                }

                                let color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)';
                                if (emp_id !== response[i]['id']) {
                                    emp_id = response[i]['id'];
                                    e_num++;
                                    if (e_num % 2 === 0) {
                                        $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                            .append($('<div>')
                                                .attr('style', 'height: 82.2px; padding: 22px 0; background: #F0F8FF')
                                                .addClass('text-center div-name')
                                                .append($('<b>')
                                                    .append($('<p>')
                                                        .addClass('emp-name text-center')
                                                        .attr('style', 'font-size: 15px')
                                                        .text(emp_name)
                                                    )
                                                )
                                            )
                                        text_color = '#000000';
                                    } else {
                                        $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                            .append($('<div>')
                                                .attr('style', 'height: 82px; padding: 22px 0')
                                                .addClass('text-center div-name')
                                                .append($('<b>')
                                                    .append($('<p>')
                                                        .addClass('emp-name text-center')
                                                        .attr('style', 'font-size: 15px')
                                                        .text(emp_name)
                                                    )
                                                )
                                            )
                                        text_color = '#F5F5DC';
                                    }
                                }
                                let event = {
                                    id: num,
                                    title: title,
                                    start: date,
                                    allDay: true,
                                    overlap: false,
                                    background: color,
                                    textColor: text_color,
                                }
                                eventSource.push(event);
                            }
                            calendar.addEventSource(eventSource);
                        }
                    })
            }

            $(".fc-goto-button")
                .after($('<select>').attr('id', 'sl-3').append($('<option>').text('Day')))
                .after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')))
                .addClass('d-none');

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

            $("#sl-3").change(function () {
                $(".fc-goto-button").click();
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

            function checkDay(d) {
                d = new Date(d);
                let day = d.getDay(),
                    diff = d.getDate() - day + (day === 0 ? -6 : 1);
                let date = new Date(d.setDate(diff));
                return date.getDay();
            }
        });
    </script>
@endpush
