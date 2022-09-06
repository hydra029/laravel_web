@extends('layout.master')
@include('ceo.menu')
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
            const calendarEl  = document.getElementById('calendar');
            let todayFullDate = getFullDate(new Date());
            let today         = new Date(new Date(todayFullDate).setHours(7));
            let firstDayTime  = new Date(new Date(new Date(todayFullDate).setHours(7)).setDate(1)).getTime();
            let tdTime        = new Date(new Date(getMon(todayFullDate)).setHours(7)).getTime();
            const calendar    = new FullCalendar.Calendar(calendarEl, {
                headerToolbar            : {
                    left  : 'today,goto',
                    center: 'title',
                    right : 'prevYear,prev,next,nextYear',
                },
                initialDate              : new Date(),
                nowIndicator             : true,
                initialView              : 'dayGridWeek',
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
                            loadDate(today);
                        }
                    },
                    goto    : {
                        text : 'Go to',
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            let day  = sl3.children(':selected').val(),
                                date = new Date(day);
                            calendar.gotoDate(date);
                            emp();
                            loadAttendance(date);
                        }
                    },
                    prevYear: {
                        click: function () {
                            let fY  = $('#sl-1 :last-child').index(),
                                idM = sl2.children(':selected').index(),
                                idY = sl1.children(':selected').index();
                            if (idY === fY) {
                                notifyError('There is no more data available');
                            } else {
                                $('#sl-1 :nth-child(' + (idY + 2) + '), #sl-2 :nth-child(' + (idM + 1) + ')')
                                    .prop('selected', true).change();
                                $(' #sl-3 :nth-child(2)').prop('selected', true).change();
                            }
                        }
                    },
                    nextYear: {
                        click: function () {
                            let idM = sl2.children(':selected').index(),
                                idY = sl1.children(':selected').index();
                            if (idY === 1) {
                                notifyError('There is no more data available');
                            } else {
                                $('#sl-1 :nth-child(' + idY + '), #sl-2 :nth-child(' + (idM + 1) + ')')
                                    .prop('selected', true).change();
                                $(' #sl-3 :nth-child(2)').prop('selected', true).change();
                            }
                        }
                    },
                    prev    : {
                        click: function () {
                            let fY     = $('#sl-1 :last-child').index(),
                                idD    = sl3.children(':selected').index(),
                                idM    = sl2.children(':selected').index(),
                                idY    = sl1.children(':selected').index(),
                                slDate = sl3.children(':selected').val(),
                                fSun   = new Date(slDate).getDate();
                            if (idD === 1) {
                                if (idY === fY && idM === 12) {
                                    notifyError('There is no more data available');
                                } else {
                                    if (fSun < 7) {
                                        if (idM === 12) {
                                            $('#sl-1 :nth-child(' + (idY + 2) + '), #sl-2 :nth-child(2)').prop('selected', true).change();
                                        } else {
                                            $('#sl-2 :nth-child(' + (idM + 2) + ')').prop('selected', true).change();
                                        }
                                        $('#sl-3 :nth-last-child(2)').prop('selected', true).change();
                                    } else {
                                        if (idM === 1) {
                                            $('#sl-1 :nth-child(' + (idY + 2) + '), #sl-2 :last-child').prop('selected', true).change();
                                        } else {
                                            $('#sl-2 :nth-child(' + (idM + 2) + ')').prop('selected', true).change();
                                        }
                                        $('#sl-3 :last-child').prop('selected', true).change();
                                    }
                                }
                            } else {
                                $('#sl-3 :nth-child(' + idD + ')').prop('selected', true).change();
                            }
                        }
                    },
                    next    : {
                        click: function () {
                            let lW     = $('#sl-3 :last-child').index(),
                                idD    = sl3.children(':selected').index(),
                                idM    = sl2.children(':selected').index(),
                                idY    = sl1.children(':selected').index(),
                                slDate = sl3.children(':selected').val(),
                                lSun   = new Date(slDate).getDay();
                            if (idD === lW) {
                                if (idM === 1) {
                                    if (idY === 1) {
                                        notifyError('There is no more data available');
                                    } else {
                                        $('#sl-1 :nth-child(' + idY + ')').prop('selected', true).change();
                                        $('#sl-2 :last-child').prop('selected', true).change();
                                        if (lSun !== 0) {
                                            $('#sl-3 :nth-child(3)').prop('selected', true).change();
                                        } else {
                                            $('#sl-3 :nth-child(2)').prop('selected', true).change();
                                        }
                                    }
                                } else {
                                    $('#sl-2 :nth-child(' + idM + ')').prop('selected', true).change();
                                    if (lSun !== 0) {
                                        $('#sl-3 :nth-child(3)').prop('selected', true).change();
                                    } else {
                                        $('#sl-3 :nth-child(2)').prop('selected', true).change();
                                    }
                                }
                            } else {
                                $('#sl-3 :nth-child(' + (idD + 2) + ')').prop('selected', true).change();
                            }
                        }
                    },
                },

                eventDidMount: function (info) {
                    if (info.event.extendedProps.background) {
                        info.el.style.background = info.event.extendedProps.background;
                    }
                }
            });
            const keys        = ['Late_1', 'Late_2', 'OnTime', 'Early_1', 'Early_2', 'OffWork', 'Miss'];
            let workTime      = {
                    ...Object.fromEntries(
                        keys.map(key => [key, 0])
                    )
                },
                overTime      = {...workTime},
                offTime       = {...workTime},
                on_time       = '#00C67F',
                miss          = '#9299A0',
                off_work      = '#FF3C28',
                late_1        = '#F38C8C',
                late_2        = '#F57542',
                early_1       = '#9761ED',
                early_2       = '#8CA5FF',
                firstShift    = [],
                secondShift   = [],
                lastShift     = [],
                eventSource   = [],
                num           = 9999,
                text_color,
                color_1,
                color_2,
                check_in,
                check_out;
            $.ajax({
                url     : '{{route('ceo.get_shift_time')}}',
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
            let goTo = $(".fc-goto-button");
            goTo
                .after($('<a>').attr({
                    id  : 'emp_detail',
                    role: 'button',
                    href: '#'
                }).addClass('btn btn-outline-primary disabled d-none'))
                .after($('<select>').attr('id', 'sl-3').append($('<option>').text('Day')))
                .after($('<select>').attr('id', 'sl-2').append($('<option>').text('Month')))
                .after($('<select>').attr('id', 'sl-1').append($('<option>').text('Year')))
                .addClass('d-none');


            $(".fc-prevYear-button")
                .before($('<select>')
                    .attr({
                        id   : 'department',
                        style: 'margin: 0 3px'
                    })
                    .append($('<option>')
                        .text('Accountant')
                        .attr('value', '1')
                    ))
                .before($('<button>')
                    .attr({
                        id   : 'back',
                        style: 'margin: 0 3px'
                    })
                    .addClass('btn btn-primary d-none')
                    .text('Back')
                )
            let sl1        = $('#sl-1'),
                sl2        = $('#sl-2'),
                sl3        = $('#sl-3'),
                department = $('#department'),
                back       = $("#back");
            emp();
            $.ajax({
                url     : '{{route('ceo.department_api')}}',
                type    : 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                    let departmentCount = response.length;
                    for (let i = 1; i < departmentCount; i++) {
                        $('#department').append($('<option>')
                            .attr('value', response[i]['id'])
                            .text(response[i]['name'])
                        )
                    }
                })

            let currentYear = new Date(today).toISOString().slice(0, 4);
            for (let i = currentYear; i >= 2020; i--) {
                sl1
                    .append($('<option>')
                        .attr('value', i)
                        .text(i)
                    )
            }

            for (let i = 12; i >= 1; i--) {
                let j = i < 10 ? '0' + i : i;
                sl2.append($('<option>')
                    .attr('value', i)
                    .text(j)
                )
            }

            function loadAttendance(date) {
                let dept_id        = department.children(':selected').val(),
                    selectedMonday = getMon(date).toISOString().slice(0, 10),
                    s              = getSun(date).toISOString().slice(0, 10),
                    selectedTime   = new Date(selectedMonday).getTime();
                $.ajax({
                    url     : '{{route('ceo.attendance_api')}}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        m      : selectedMonday,
                        s      : s,
                        dept_id: dept_id
                    },
                })
                    .done(function (response) {
                        $('.div-name').remove()
                        let emp_types = response.length,
                            e_num     = 0,
                            nShift    = 0;
                        Object.keys(workTime).forEach(key => {
                            workTime[key] = 0;
                        });
                        overTime    = {...workTime};
                        offTime     = {...workTime};
                        eventSource = [];
                        for (let k = 1; k < emp_types; k++) {
                            let emp_id  = 0,
                                emp_num = response[k].length;
                            for (let i = 0; i < emp_num; i++) {
                                emp_id = response[k][i]['id'];
                                e_num++;
                                let {
                                        id  : dept_id,
                                        name: department
                                    }        = response[k][i]['departments'],
                                    {
                                        id  : role_id,
                                        name: role
                                    }        = response[k][i]['roles'],
                                    emp_name = response[k][i]['fname'] + ' ' + response[k][i]['lname'];
                                emp_name += role === 'Manager' ? '*' : '';
                                let emp_role = role_id === 1 ? 2 : dept_id === 1 ? 3 : 1;
                                $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                    .append($('<div>')
                                        .addClass('text-center div-name')
                                        .append($('<a>')
                                            .append($('<b>')
                                                .addClass('emp-name text-center')
                                                .attr({
                                                    "data-id"  : emp_id,
                                                    "data-role": emp_role,
                                                })
                                                .text(emp_name)
                                            )
                                            .append('<br>')
                                            .append($('<p>')
                                                .addClass('emp-dept text-center')
                                                .text(department)
                                            )
                                        )
                                    )
                                if (e_num % 2 === 0) {
                                    text_color = '#F5F5DC';
                                    $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child > :last-child').css('background', '#F0F8FF')
                                } else {
                                    text_color = '#000000';
                                }
                                let date   = selectedMonday,
                                    length = response[k][i]['attendance'].length;
                                if (length === 0) {
                                    let currentMonday = getMon(today).toISOString().slice(0, 10),
                                        currentDay    = new Date(todayFullDate).getDay(),
                                        totalDay      = currentMonday === selectedMonday ? currentDay === 0 ? 7 : currentDay : 7;
                                    date              = getFullDate(selectedMonday);
                                    if (date <= todayFullDate) {
                                        for (let i = 1; i <= totalDay; i++) {
                                            addEvent(date);
                                            date = getNextDate(date);
                                        }
                                    }
                                } else {
                                    let defaultDate = selectedMonday;
                                    for (let j = 0; j < length; j++) {
                                        let shift      = response[k][i]['attendance'][j]['shift'],
                                            date       = response[k][i]['attendance'][j]['date'],
                                            defaultDay = getDay(defaultDate),
                                            currentDay = getDay(date);
                                        check_in       = response[k][i]['attendance'][j]['check_in'];
                                        check_out      = response[k][i]['attendance'][j]['check_out'];
                                        defaultDay     = defaultDay === 0 ? 7 : defaultDay;
                                        currentDay     = currentDay === 0 ? 7 : currentDay;
                                        if (j === 0) {
                                            addEvent(date, defaultDay, shift);
                                            if (defaultDay < currentDay) {
                                                let offworkDate = selectedMonday;
                                                for (let n = 1; n < currentDay; n++) {
                                                    addEvent(offworkDate);
                                                    offworkDate = getNextDate(offworkDate)
                                                }
                                            }
                                        } else {
                                            addEvent(date, defaultDate, shift, nShift);
                                            if (defaultDay !== currentDay) {
                                                if (currentDay - defaultDay > 0) {
                                                    let offworkDate = getNextDate(defaultDate);
                                                    for (let n = defaultDay + 1; n < currentDay; n++) {
                                                        addEvent(offworkDate);
                                                        offworkDate = getNextDate(offworkDate);
                                                    }
                                                }
                                            }
                                        }
                                        defaultDate = date;
                                        if (check_in !== null) {
                                            check_in = check_in.slice(0, 5);
                                        }
                                        if (check_out !== null) {
                                            check_out = check_out.slice(0, 5);
                                        }
                                        checkTime(check_in, check_out, shift, date);
                                        nShift    = shift;
                                        let title = check_in + Array(14).fill('\xa0').join('') + check_out;
                                        let color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)';
                                        let event = {
                                            id        : num,
                                            title     : title,
                                            start     : date,
                                            allDay    : true,
                                            overlap   : false,
                                            background: color,
                                            textColor : text_color,
                                        }
                                        eventSource.push(event);
                                    }
                                    let lastDate = response[k][i]['attendance'][length - 1]['date'],
                                        days     = getDay(lastDate),
                                        day      = getDay(new Date()),
                                        totalDay = 7;
                                    days         = days === 0 ? 7 : days;
                                    day          = day === 0 ? 7 : day;
                                    if (days < totalDay) {
                                        let date = getNextDate(lastDate);
                                        totalDay = selectedTime === tdTime ? day : totalDay;
                                        if (selectedTime <= tdTime) {
                                            addEvent(lastDate, '', 0, nShift);
                                        }
                                        for (let i = days + 1; i <= totalDay; i++) {
                                            addEvent(date);
                                            date = getNextDate(date);
                                        }
                                    }
                                }
                            }
                        }
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
                        calendar.addEventSource(eventSource);
                        $(".emp-name").click(function () {
                            Object.keys(workTime).forEach(key => {
                                workTime[key] = 0;
                            });
                            overTime       = {...workTime};
                            offTime        = {...workTime};
                            eventSource    = [];
                            num            = 9999;
                            nShift         = 0;
                            let name       = $(this).text(),
                                department = $(this).parent().find('.emp-dept').text(),
                                text       = name + ' - ' + department;
                            $('#emp_detail').text(text);
                            $('#sl-1, #sl-2, #sl-3, #department, .fc-button').addClass('d-none');
                            $('#back, #emp_detail').removeClass('d-none');
                            calendar.removeAllEvents();
                            del();
                            calendar.changeView('dayGridMonth');
                            let id             = $(this).data('id'),
                                role           = $(this).data('role'),
                                selectedMonday = sl2.children(':selected').text(),
                                y              = sl1.children(':selected').text(),
                                crD            = y + '-' + selectedMonday,
                                selectedTime   = new Date(crD).getTime();
                            $.ajax({
                                url     : '{{route('ceo.emp_attendance_api')}}',
                                type    : 'POST',
                                dataType: 'json',
                                data    : {
                                    id  : id,
                                    role: role,
                                    date: crD
                                },
                            })
                                .done(function (response) {
                                    let shiftCount  = response.length,
                                        defaultDate = getFullDate(crD),
                                        totalDay    = getDays(crD),
                                        crDate      = new Date(todayFullDate).getDate();
                                    if (shiftCount > 0) {
                                        for (let i = 0; i < shiftCount; i++) {
                                            id--;
                                            check_in  = response[i]['check_in'];
                                            check_out = response[i]['check_out'];
                                            let shift = response[i]['shift'],
                                                date  = response[i]['date'],
                                                d1    = getDate(defaultDate),
                                                d2    = getDate(date);
                                            if (i === 0) {
                                                addEvent(date, defaultDate, shift)
                                                if (d1 < d2) {
                                                    let off_date = getFullDate(crD);
                                                    for (let n = 1; n < d2; n++) {
                                                        addEvent(off_date);
                                                        off_date = getNextDate(off_date)
                                                    }
                                                }
                                            } else {
                                                addEvent(date, defaultDate, shift, nShift)
                                                if (d1 !== d2) {
                                                    if (d2 - d1 > 0) {
                                                        let off_date = getNextDate(defaultDate);
                                                        for (let i = d1 + 1; i < d2; i++) {
                                                            addEvent(off_date);
                                                            off_date = getNextDate(off_date);
                                                        }
                                                    }
                                                }
                                            }
                                            defaultDate = date;
                                            if (check_in !== null) {
                                                check_in = check_in.slice(0, 5);
                                            }
                                            if (check_out !== null) {
                                                check_out = check_out.slice(0, 5);
                                            }
                                            checkTime(check_in, check_out, shift, date)
                                            nShift    = shift;
                                            let title = check_in + Array(14).fill('\xa0').join('') + check_out,
                                                color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)',
                                                event = {
                                                    id        : num,
                                                    title     : title,
                                                    start     : date,
                                                    allDay    : true,
                                                    overlap   : false,
                                                    background: color,
                                                }
                                            eventSource.push(event);
                                        }
                                        let lastDate = response[shiftCount - 1]['date'],
                                            days     = getDate(lastDate);
                                        if (days < totalDay) {
                                            totalDay = selectedTime === firstDayTime ? crDate : totalDay;
                                            if (selectedTime <= firstDayTime) {
                                                addEvent(lastDate, '', 0, nShift)
                                                for (let i = days + 1; i <= totalDay; i++) {
                                                    let currentDate = new Date(lastDate).setDate(i),
                                                        date        = getFullDate(currentDate);
                                                    addEvent(date)
                                                }
                                            }
                                        }
                                    } else {
                                        totalDay = firstDayTime === selectedTime ? crDate : totalDay;
                                        if (selectedTime <= firstDayTime) {
                                            for (let i = 1; i <= totalDay; i++) {
                                                let currentDate = new Date(defaultDate);
                                                currentDate.setDate(i);
                                                let date = getFullDate(currentDate);
                                                addEvent(date)
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
                        })
                    })
            }

            loadDate(new Date(), 1);
            sl1.change(() => loadWeek());
            sl2.change(() => loadWeek());
            sl3.change(() => goTo.click());

            department.change(function () {
                calendar.removeAllEvents();
                del();
                let date = calendar.getDate();
                calendar.gotoDate(date);
                emp();
                loadAttendance(date);
            })

            back.click(function () {
                calendar.changeView('dayGridWeek');
                $('#sl-1, #sl-2, #sl-3, #department, .fc-button').removeClass('d-none');
                $('#back, #emp_detail, .fc-goto-button').addClass('d-none');
                goTo.click();
            })

            function loadDate(date, status = 0) {
                date               = new Date(date);
                let currentDay     = date.getDay(),
                    currentDate    = date.getDate(),
                    currentMonth   = date.getMonth() + 1,
                    currentYear    = date.getFullYear(),
                    selectedMonday = sl2.children(':selected').val(),
                    selectedYear   = sl1.children(':selected').val();
                currentDay         = currentDay === 0 ? 7 : currentDay;
                let slDate         = getDays(date);
                let crDate         = currentDate - currentDay + 7;
                if (crDate >= slDate) {
                    crDate = slDate;
                }
                let selectedDate = new Date(currentYear, currentMonth - 1, crDate).setHours(7);
                selectedDate     = getFullDate(selectedDate);
                if (currentMonth !== selectedMonday) {
                    sl1.val(currentYear).change();
                }
                if (currentYear !== selectedYear) {
                    sl2.val(currentMonth).change();
                }
                loadWeek();
                sl3.val(selectedDate).change();
                if (status === 1) {
                    goTo.click();
                }
            }

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
                                    id   : 'emp_name'
                                })
                                .text('Name')
                            )
                        )
                    );
            }

            function loadWeek() {
                sl3.empty();
                sl3.append($('<option>').text('Day'));
                let j     = 0,
                    ar    = '',
                    arr1  = [],
                    year  = sl1.children(':selected').val(),
                    month = sl2.children(':selected').val(),
                    days  = new Date(year, month, 0).getDate(),
                    fd    = new Date(year, month - 1, 1).getDay(),
                    pMon  = month - 1,
                    nMon  = month - 0 + 1;
                month < 10 && (month = '0' + month);
                month < 11 ? (pMon = '0' + pMon) : month === 1 && (pMon = 12);
                month < 9 ? nMon = '0' + nMon : month === 12 && (nMon = '01');

                if (fd !== 0) {
                    let mon = new Date(year, month - 1, 2 - fd).getDate();
                    mon === 1 && (mon = '01');
                    mon = mon + '/' + pMon;
                    arr1.push(mon);
                }
                for (let i = 2; i <= days; i++) {
                    j = i;
                    i < 10 && (j = '0' + i);
                    let n    = new Date(year, month - 1, i).getDay(),
                        data = j + '/' + month;
                    if (n === 1) {
                        arr1.push(data)
                    } else if (n === 0) {
                        let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                        arr1.push(data);
                        ar = arr1[0] + '-' + arr1[1];
                        sl3.append($('<option>')
                            .attr({
                                value: val,
                            })
                            .text(ar)
                        )
                        arr1 = [];
                    } else {
                        if (i === days) {
                            let val         = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                            fd              = new Date(year, month, i).getDay();
                            let checkSunday = new Date(year, month, 6 - i).getDate();
                            checkSunday     = '0' + checkSunday + '/' + nMon;
                            arr1.push(checkSunday);
                            ar = arr1[0] + '-' + arr1[1];
                            sl3.append($('<option>')
                                .attr({
                                    value: val,
                                })
                                .text(ar)
                            )
                            arr1 = [];
                        }
                    }
                }
            }

            function getSun(date) {
                date     = new Date(date);
                let day  = date.getDay(),
                    diff = date.getDate() + (day === 0 ? 0 : 7 - day);
                return new Date(date.setDate(diff));
            }

            function getMon(date) {
                date     = new Date(date);
                let day  = date.getDay(),
                    diff = date.getDate() - day + (day === 0 ? -6 : 1);
                return new Date(date.setDate(diff));
            }

            function getPreDate(date) {
                date   = new Date(date);
                let id = date.getDate()
                date   = date.setDate(id - 1)
                return new Date(date).toISOString().slice(0, 10);
            }

            function getNextDate(date) {
                date   = new Date(date);
                let id = date.getDate()
                date   = date.setDate(id + 1)
                return new Date(date).toISOString().slice(0, 10);
            }

            function getFullDate(date) {
                return new Date(date).toISOString().slice(0, 10);
            }

            function getDate(date) {
                return new Date(date).getDate();
            }

            function getDay(date) {
                return new Date(date).getDay();
            }

            function getDays(date) {
                date         = new Date(date);
                let month    = date.getMonth() + 1;
                let lDate    = new Date(date.setDate(1));
                let lastDate = new Date(lDate.setMonth(month));
                date         = new Date(lastDate.setDate(0));
                return new Date(date).getDate();
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
                                background: off_work,
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
                        background: off_work,
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
        })
	</script>
@endpush