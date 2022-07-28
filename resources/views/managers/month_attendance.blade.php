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
                weekNumbers: true,
                weekNumberCalculation: 'ISO',
                editable: true,
                selectable: true,
                height: 750,
                contentHeight: 100,
                dayMaxEvents: true,
                initialView: 'dayGridMonth',
                eventOrder: "-id",
                customButtons: {
                    today: {
                        text: 'Today',
                        click: function () {
                            let date = new Date();
                            loadDate(date)
                        }
                    },
                    goto: {
                        text: 'Go to',
                        click: function () {
                            calendar.removeAllEvents();
                            let year = sl1.children(':selected').val();
                            let month = sl2.children(':selected').val();
                            if (month < 10) {
                                month = '0' + month;
                            }
                            let gDate = year + '-' + month + '-01';
                            let date = new Date(gDate);
                            calendar.gotoDate(date);
                            loadAttendance(date);
                        }
                    },
                    prevYear: {
                        click: function () {
                            let fY = $('#sl-1 :last-child').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idY === fY) {
                                $.toast({
                                    heading: 'Something went wrong',
                                    text: 'There is no more data available',
                                    icon: 'info',
                                    position: 'top-right',
                                    hideAfter: 2000,
                                });
                            } else {
                                $('#sl-1 :nth-child(' + (idY + 2) + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (idM + 1) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    nextYear: {
                        click: function () {
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idY === 1) {
                                $.toast({
                                    heading: 'Something went wrong',
                                    text: 'There is no more data available',
                                    icon: 'info',
                                    position: 'top-right',
                                    hideAfter: 2000,
                                });
                            } else {
                                $('#sl-1 :nth-child(' + idY + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (idM + 1) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    prev: {
                        click: function () {
                            let fY = $('#sl-1 :last-child').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idM === 12) {
                                if (idY === fY) {
                                    $.toast({
                                        heading: 'Something went wrong',
                                        text: 'There is no more data available',
                                        icon: 'info',
                                        position: 'top-right',
                                        hideAfter: 2000,
                                    });
                                } else {
                                    $('#sl-1 :nth-child(' + (idY + 2) + ')').prop('selected', true).change();
                                    $('#sl-2 :nth-child(2)').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (idM + 2) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    next: {
                        click: function () {
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idM === 1) {
                                if (idY === 1) {
                                    $.toast({
                                        heading: 'Something went wrong',
                                        text: 'There is no more data available',
                                        icon: 'info',
                                        position: 'top-right',
                                        hideAfter: 2000,
                                    });
                                } else {
                                    $('#sl-1 :nth-child(' + (idY) + ')').prop('selected', true).change();
                                    $('#sl-2 :last-child').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (idM) + ')').prop('selected', true).change();
                            }
                        }
                    }
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.background) {
                        info.el.style.background = info.event.extendedProps.background;
                    }
                },

            });

            calendar.render();
            loadAttendance(today);

            $(".fc-goto-button")
                .after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')))
                .addClass('d-none');

            const sl1 = $('#sl-1');
            const sl2 = $('#sl-2');

            let crYear = new Date().getFullYear();

            for (let i = crYear; i >= 2020; i--) {
                sl1.append($('<option>')
                    .attr('value', i)
                    .text(i)
                    .addClass('y-opt')
                )
            }

            for (let i = 12; i >= 1; i--) {
                let j = i;
                if (i < 10) {
                    j = '0' + i;
                    j
                }
                sl2.append($('<option>')
                    .attr('value', i)
                    .text(j)
                    .addClass('m-opt')
                )
            }

            let d = calendar.getDate();
            loadDate(d);

            function loadAttendance(d) {
                let f = getFDay(d).toISOString().slice(0, 10);
                let l = getLDay(d).toISOString().slice(0, 10);
                let num = 9998;
                $.ajax({
                    url: '{{route('managers.attendance_api')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {f: f, l: l},
                })
                    .done(function (response) {
                        let emp_num = response.length;
                        for (let i = 0; i <= emp_num; i++) {
                            num--;
                            let date = response[i]['date'];
                            let check_in = response[i]['check_in'].slice(0, 5);
                            let check_out = response[i]['check_out'].slice(0, 5);
                            let check_in_start = response[i]['shifts']['check_in_start'].slice(0, 5);
                            let check_in_end = response[i]['shifts']['check_in_end'].slice(0, 5);
                            let check_in_late_1 = response[i]['shifts']['check_in_late_1'].slice(0, 5);
                            let check_in_late_2 = response[i]['shifts']['check_in_late_2'].slice(0, 5);
                            let check_out_start = response[i]['shifts']['check_out_start'].slice(0, 5);
                            let check_out_end = response[i]['shifts']['check_out_end'].slice(0, 5);
                            let check_out_early_1 = response[i]['shifts']['check_out_early_1'].slice(0, 5);
                            let check_out_early_2 = response[i]['shifts']['check_out_early_2'].slice(0, 5);
                            let title = check_in + Array(20).fill('\xa0').join('') + check_out;
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
                            let event = {
                                id: num,
                                title: title,
                                start: date,
                                allDay: true,
                                overlap: false,
                                background: color,
                            }
                            calendar.addEvent(event);
                        }
                    })
            }

            sl2.change(function () {
                $(".fc-goto-button").click();
            })

            function loadDate(d) {
                let cm = d.getMonth() + 1;
                let cy = d.getFullYear();
                sl1.val(cy).change();
                sl2.val(cm).change();
            }

            function getFDay(d) {
                d = new Date(d);
                return new Date(d.setDate(1));
            }

            function getLDay(d) {
                d = new Date(d);
                let m = d.getMonth() + 1;
                let l = new Date(d.setMonth(m));
                return new Date(l.setDate(0));
            }
        });
    </script>
@endpush
