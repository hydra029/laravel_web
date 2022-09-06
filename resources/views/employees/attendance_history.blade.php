@extends('layout.master')
@include('employees.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="{{ asset('css/fullcalendar.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
@endpush
@section('content')
    <div class="col-2 p-1">
        <table id="table_salary">
            <tr>
                <th class="col-6">Type</th>
                <th class="type col-2">WD</th>
                <th class="type col-2">OT</th>
                <th class="type col-2">OD</th>
            </tr>
        </table>
        <div id='external-events'>
            <div class='fc-event fc-h-event event-1'>
                <div class='fc-event-main tc event-0'>
                    <span class="text-left">Early 1:</span>
                    <span class="E13 col-2"></span>
                    <span class="E12 col-2"></span>
                    <span class="E11 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-2'>
                <div class='fc-event-main tc event-0'>
                    <span>Early 2:</span>
                    <span class="E23 col-2"></span>
                    <span class="E22 col-2"></span>
                    <span class="E21 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-3'>
                <div class='fc-event-main tc event-0'>
                    <span>On Time:</span>
                    <span class="OT3 col-2"></span>
                    <span class="OT2 col-2"></span>
                    <span class="OT1 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-4'>
                <div class='fc-event-main tc event-0'>
                    <span>Late 1:</span>
                    <span class="L13 col-2"></span>
                    <span class="L12 col-2"></span>
                    <span class="L11 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-5'>
                <div class='fc-event-main tc event-0'>
                    <span>Late 2:</span>
                    <span class="L23 col-2"></span>
                    <span class="L22 col-2"></span>
                    <span class="L21 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-6'>
                <div class='fc-event-main tc event-0'>
                    <span>Miss:</span>
                    <span class="MS3 col-2"></span>
                    <span class="MS2 col-2"></span>
                    <span class="MS1 col-2"></span>
                </div>
            </div>
            <div class='fc-event fc-h-event event-7'>
                <div class='fc-event-main tc event-0'>
                    <span>
                        Off Work:
                    </span>
                    <span class="OW3 col-2"></span>
                    <span class="OW2 col-2"></span>
                    <span class="OW1 col-2"></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-10 p-1">
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
            let todayDate    = getFullDate(new Date());
            let today        = new Date(new Date(todayDate).setHours(7));
            let todayTime    = new Date(today.setDate(1)).getTime();
            const calendar   = new FullCalendar.Calendar(calendarEl, {
                headerToolbar            : {
                    left  : 'today,goto',
                    center: 'title',
                    right : 'prevYear,prev,next,nextYear',
                },
                initialDate              : new Date(),
                nowIndicator             : true,
                initialView              : 'dayGridMonth',
                weekNumbers              : true,
                weekNumberCalculation    : 'ISO',
                editable                 : false,
                selectable               : true,
                height                   : 750,
                contentHeight            : 100,
                dayMaxEvents             : true,
                eventOrderStrict         : true,
                progressiveEventRendering: true,
                eventOrder               : '-id',
                customButtons            : {
                    today   : {
                        text : 'Today',
                        click: function () {
                            loadDate(new Date());
                        }
                    },
                    goto    : {
                        text : 'Go to',
                        click: function () {
                            calendar.removeAllEvents();
                            let year  = sl1.children(':selected').val();
                            let month = sl2.children(':selected').val();
                            month < 10 && (month = '0' + month);
                            let selectedDate = year + '-' + month + '-01';
                            let date         = new Date(selectedDate);
                            calendar.gotoDate(date);
                            loadAttendance(date);
                        }
                    },
                    prevYear: {
                        click: function () {
                            let monthIndex = sl2.children(':selected').index();
                            let yearIndex  = sl1.children(':selected').index();
                            if (yearIndex === firstYear) {
                                notifyError('There is no more data available');
                            } else {
                                $('#sl-1 :nth-child(' + (yearIndex + 2) + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (monthIndex + 1) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    nextYear: {
                        click: function () {
                            let monthIndex = sl2.children(':selected').index();
                            let yearIndex  = sl1.children(':selected').index();
                            if (yearIndex === 1) {
                                notifyError('There is no more data available');
                            } else {
                                $('#sl-1 :nth-child(' + yearIndex + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (monthIndex + 1) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    prev    : {
                        click: function () {
                            let monthIndex = sl2.children(':selected').index();
                            let yearIndex  = sl1.children(':selected').index();
                            if (monthIndex === 12) {
                                if (yearIndex === firstYear) {
                                    notifyError('There is no more data available');
                                } else {
                                    $('#sl-1 :nth-child(' + (yearIndex + 2) + ')').prop('selected', true).change();
                                    $('#sl-2 :nth-child(2)').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (monthIndex + 2) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    next    : {
                        click: function () {
                            let monthIndex = sl2.children(':selected').index();
                            let yearIndex  = sl1.children(':selected').index();
                            if (monthIndex === 1) {
                                if (yearIndex === 1) {
                                    notifyError('There is no more data available');
                                } else {
                                    $('#sl-1 :nth-child(' + (yearIndex) + ')').prop('selected', true).change();
                                    $('#sl-2 :last-child').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (monthIndex) + ')').prop('selected', true).change();
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
            const keys       = ['Late_1', 'Late_2', 'OnTime', 'Early_1', 'Early_2', 'OffWork', 'Miss'];
            let workTime     = {
                    ...Object.fromEntries(
                            keys.map(key => [key, 0])
                    )
                },
                overTime     = {...workTime},
                offTime      = {...workTime},
                on_time      = '#00c67f',
                miss         = '#9299a0',
                off_work     = '#f03e44',
                late_1       = '#f07171',
                late_2       = '#f57542',
                early_1      = '#9761ed',
                early_2      = '#8ca5ff',
                color_1      = off_work,
                color_2      = off_work,
                firstShift   = [],
                secondShift  = [],
                lastShift    = [],
                eventSource  = [],
                check_in,
                check_out;
            $.ajax({
                url     : '{{route('employees.get_shift_time')}}',
                dataType: 'json',
                method  : 'GET',
            })
                    .done(function (response) {
                        for (let i = 0; i < response.length; i++) {
                            Object.keys(response[i]).forEach(key => {
                                response[i][key] = response[i][key].slice(0, 5);
                            });
                        }
                        firstShift  = response[0];
                        secondShift = response[1];
                        lastShift   = response[2];
                    })
            calendar.render();
            loadAttendance(today);

            $(".fc-goto-button")
                    .after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                    .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')))
                    .addClass('d-none');

            let currentYear = new Date().getFullYear(),
                firstYear   = $('#sl-1 :last-child').index();
            const sl1       = $('#sl-1');
            const sl2       = $('#sl-2');

            for (let i = currentYear; i >= 2020; i--) {
                sl1.append($('<option>')
                        .attr('value', i)
                        .text(i)
                )
            }

            for (let i = 12; i >= 1; i--) {
                let j = i;
                if (i < 10) {
                    j = '0' + i;
                }
                sl2.append($('<option>')
                        .attr('value', i)
                        .text(j)
                )
            }

            loadDate(new Date());
            let num = 9998;

            function loadAttendance(date) {
                let first_day      = getFirstDate(date),
                    last_day      = getLastDate(date),
                    crTime = new Date(first_day).getTime(),
                    crDate = getDate(todayDate);
                $.ajax({
                    url     : '{{ route('employees.history_api') }}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        first_day: first_day,
                        last_day: last_day
                    },
                })
                        .done(function (response) {
                            Object.keys(workTime).forEach(key => {
                                workTime[key] = 0;
                            });
                            Object.keys(overTime).forEach(key => {
                                overTime[key] = 0;
                            });
                            Object.keys(offTime).forEach(key => {
                                offTime[key] = 0;
                            });
                            eventSource      = []
                            let shift_num    = response.length,
                                selectedDate = first_day,
                                nextShift    = 0,
                                total_day    = getDayCount(first_day);
                            if (shift_num > 0) {
                                for (let i = 0; i < shift_num; i++) {
                                    num--;
                                    let currentShift = response[i]['shift'],
                                        date         = response[i]['date'];
                                    check_in         = response[i]['check_in'];
                                    check_out        = response[i]['check_out'];

                                    let defaultDate = getDate(selectedDate);
                                    let currentDate = getDate(date);
                                    if (i === 0) {
                                        addEvent(date, selectedDate, currentShift)
                                        if (defaultDate < currentDate) {
                                            let offDate = first_day;
                                            for (let n = 1; n < currentDate; n++) {
                                                addEvent(offDate)
                                                offDate = getNextDate(offDate)
                                            }
                                        }
                                    } else {
                                        addEvent(date, selectedDate, currentShift, nextShift);
                                        if (currentDate !== defaultDate) {
                                            if (currentDate - defaultDate > 0) {
                                                let offDate = getNextDate(selectedDate);
                                                for (let n = defaultDate + 1; n < currentDate; n++) {
                                                    addEvent(offDate);
                                                    offDate = getNextDate(offDate);
                                                }
                                            }
                                        }
                                    }
                                    selectedDate = date;
                                    check_in !== null && (check_in = check_in.slice(0, 5));
                                    check_out !== null && (check_out = check_out.slice(0, 5));
                                    checkTime(check_in, check_out, currentShift, date);
                                    nextShift = currentShift === 1 ? 1 : currentShift === 2 ? 2 : 3;
                                    let title = check_in + Array(16).fill('\xa0').join('') + check_out;
                                    let color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)';
                                    let event = {
                                        id        : num,
                                        title     : title,
                                        start     : date,
                                        allDay    : true,
                                        overlap   : false,
                                        background: color,
                                    }
                                    eventSource.push(event);
                                }
                                let lastDate = response[shift_num - 1]['date'];
                                let days     = getDate(lastDate);
                                let crDate   = new Date().getDate();
                                if (days < total_day) {
                                    if (crTime === todayTime) {
                                        total_day = crDate;
                                    }
                                    if (crTime <= todayTime) {
                                        addEvent(lastDate, '', 0, nextShift);
                                    }
                                    for (let i = days + 1; i <= total_day; i++) {
                                        let selectedDate = new Date(lastDate)
                                        let date         = getFullDate(selectedDate.setDate(i));
                                        addEvent(date)
                                    }
                                }
                            } else {
                                if (todayTime === crTime) {
                                    total_day = crDate;
                                }
                                if (crTime <= todayTime) {
                                    for (let i = 1; i <= total_day; i++) {
                                        let date = getFullDate(new Date(selectedDate).setDate(i));
                                        addEvent(date);
                                    }
                                }
                            }
                            calendar.addEventSource(eventSource);
                            $('.E11').text(workTime['Early_1']);
                            $('.E21').text(workTime['Early_2']);
                            $('.OT1').text(workTime['OnTime']);
                            $('.L11').text(workTime['Late_1']);
                            $('.L21').text(workTime['Late_2']);
                            $('.MS1').text(workTime['Miss']);
                            $('.OW1').text(workTime['OffWork']);
                            $('.E12').text(overTime['Early_1']);
                            $('.E22').text(overTime['Early_2']);
                            $('.OT2').text(overTime['OnTime']);
                            $('.L12').text(overTime['Late_1']);
                            $('.L22').text(overTime['Late_2']);
                            $('.MS2').text(overTime['Miss']);
                            $('.OW2').text(overTime['OffWork']);
                            $('.E13').text(offTime['Early_1']);
                            $('.E23').text(offTime['Early_2']);
                            $('.OT3').text(offTime['OnTime']);
                            $('.L13').text(offTime['Late_1']);
                            $('.L23').text(offTime['Late_2']);
                            $('.MS3').text(offTime['Miss']);
                            $('.OW3').text(offTime['OffWork']);
                        })
            }

            sl2.change(function () {
                $(".fc-goto-button").click();
            })

            function loadDate(date) {
                let cm = date.getMonth() + 1;
                let cy = date.getFullYear();
                sl1.val(cy).change();
                sl2.val(cm).change();
            }

            function getFirstDate(date) {
                date = new Date(date);
                return new Date(date.setDate(1)).toISOString().slice(0, 10);
            }

            function getLastDate(date) {
                date  = new Date(date);
                let last_day = new Date(date.setMonth(date.getMonth() + 1));
                return new Date(last_day.setDate(0)).toISOString().slice(0, 10);
            }

            function getDayCount(date) {
                date  = new Date(date);
                let last_day = new Date(date.setMonth(date.getMonth() + 1));
                date  = new Date(last_day.setDate(0));
                return new Date(date).getDate();
            }

            function getPreDate(date) {
                date = new Date(date).setDate(getDate(date) - 1)
                return new Date(date).toISOString().slice(0, 10);
            }

            function getNextDate(date) {
                date = new Date(date).setDate(getDate(date) + 1)
                return new Date(date).toISOString().slice(0, 10);
            }

            function getDate(date) {
                return new Date(date).getDate();
            }

            function getFullDate(date) {
                return new Date(date).toISOString().slice(0, 10);
            }

            function getDay(date) {
                return new Date(date).getDay();
            }

            function checkSunday(date) {
                return new Date(date).getDay() === 0;
            }

            function addEvent(date, defaultDate = '', currentShift = 0, nextShift = 0) {
                let event,
                    i,
                    shiftCount         = 0,
                    previousShiftCount = 0;
                if (currentShift === 0 && nextShift === 0) {
                    shiftCount = 3;
                    offTime['OffWork'] += checkSunday(date) && shiftCount * 2;
                    workTime['OffWork'] += !checkSunday(date) && (shiftCount - 1) * 2;
                    overTime['OffWork'] += !checkSunday(date) && 2;
                } else if (currentShift !== 0 && nextShift === 0) {
                    shiftCount = currentShift - 1;
                    offTime['OffWork'] += checkSunday(date) && shiftCount * 2;
                    workTime['OffWork'] += !checkSunday(date) && shiftCount * 2;
                } else if (currentShift === 0 && nextShift !== 0) {
                    shiftCount = 3 - nextShift;
                    offTime['OffWork'] += checkSunday(date) && (shiftCount * 2);
                    overTime['OffWork'] += !checkSunday(date) && (shiftCount !== 0 && 2);
                    workTime['OffWork'] += !checkSunday(date) && (shiftCount === 2 && 2);
                } else {
                    if (defaultDate === date && currentShift - nextShift > 1) {
                        shiftCount = 1;
                        offTime['OffWork'] += checkSunday(date) && 2;
                        workTime['OffWork'] += !checkSunday(date) && 2;
                    } else if (defaultDate !== date) {
                        previousShiftCount = 3 - nextShift;
                        i                  = 0;
                        while (i < previousShiftCount) {
                            i++;
                            let event = {
                                id        : num,
                                start     : defaultDate,
                                allDay    : true,
                                overlap   : false,
                                background: '#f03e44',
                            }
                            eventSource.push(event);
                            num--;
                        }
                        shiftCount = currentShift - 1;
                        offTime['OffWork'] += checkSunday(defaultDate) ? previousShiftCount * 2 : checkSunday(date) && shiftCount * 2;
                        workTime['OffWork'] += !checkSunday(defaultDate) && (previousShiftCount === 2 && 2);
                        workTime['OffWork'] += !checkSunday(date) && shiftCount * 2;
                        overTime['OffWork'] += !checkSunday(defaultDate) && (previousShiftCount !== 0 && 2);
                    }
                }
                i = 0;
                while (i < shiftCount) {
                    i++;
                    event = {
                        id        : num,
                        start     : date,
                        allDay    : true,
                        overlap   : false,
                        background: '#f03e44',
                    }
                    eventSource.push(event);
                    num--;
                }
            }

            function checkTime(check_in_time, check_out_time, currentShift, date) {
                let selectedShift,
                    time;
                checkSunday(date) ? time = offTime : currentShift === 3 ? time = overTime : time = workTime;
                selectedShift = currentShift === 1 ? firstShift : currentShift === 2 ? secondShift : lastShift;
                if (check_in_time === null) {
                    check_in = Array(10).fill('\xa0').join('');
                    color_1  = miss;
                    time['Miss']++;
                } else if (check_in_time <= selectedShift['check_in_end']) {
                    check_in = Array(10).fill('\xa0').join('');
                    color_1  = on_time;
                    time['OnTime']++;
                } else if (check_in_time <= selectedShift['check_in_late_1']) {
                    color_1 = late_1;
                    time['Late_1']++;
                } else {
                    color_1 = late_2;
                    time['Late_2']++;
                }

                if (check_out_time === null) {
                    check_out = Array(10).fill('\xa0').join('');
                    color_2   = miss;
                    time['Miss']++;
                } else if (check_out_time >= selectedShift['check_out_start']) {
                    check_out = Array(10).fill('\xa0').join('');
                    color_2   = on_time;
                    time['OnTime']++;
                } else if (check_out_time >= selectedShift['check_out_early_2']) {
                    color_2 = early_2;
                    time['Early_2']++;
                } else {
                    color_2 = early_1;
                    time['Early_1']++;
                }
            }

            function notifyError(message = 'There is no more data available') {
                $.toast({
                    heading        : 'Something went wrong',
                    text           : message,
                    icon           : 'info',
                    position       : 'top-right',
                    hideAfter      : 2000,
                    allowToastClose: false,
                });
            }
        });
    </script>
@endpush