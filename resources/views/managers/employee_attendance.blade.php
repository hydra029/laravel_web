@extends('layout.master')
@include('managers.menu')
@push('css')
	<link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<link href="{{ asset('css/fullcalendar.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<style>
        .modal-header, .modal-footer {
            display: block;
        }

        .btn-modal {
            margin: 0 10px;
        }
	</style>
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
	<div id="success-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel"
	     aria-hidden="true">
		<div class="modal-dialog modal-sm modal-dialog-centered">
			<div class="modal-content modal-filled bg-success">
				<div class="modal-header text-center">
					<h4 class="modal-title" id="standard-modalLabel">Confirmation</h4>
				</div>
				<div class="modal-body p-4">
					<div class="text-center">
						<i class="dripicons-checkmark h1"></i>
						<h4 class="mt-2">Be careful !!!</h4>
						<p class="mt-3">It's your last choice ?</p>
						<p class="mt-3"> You can't change after confirm !</p>
					</div>
				</div>
				<div class="modal-footer">
					<div class="text-center">
						<button id="confirmed" type="button" class="btn btn-primary btn-modal">Confirm</button>
						<button id="cancel" type="button" class="btn btn-light btn-modal" data-dismiss="modal">Cancel
						</button>
					</div>
				</div>
			</div>
		</div>
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
            let td           = getFullDate(new Date()),
                today        = new Date(new Date(td).setHours(7)),
                mTime        = new Date(new Date(new Date(td).setHours(7)).setDate(1)).getTime(),
                tdTime       = new Date(new Date(getMon(td)).setHours(7)).getTime();
            const calendar   = new FullCalendar.Calendar(calendarEl, {
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
                            loadDate(new Date());
                        }
                    },
                    goto    : {
                        text : 'Go to',
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            let day  = sl3.children(':selected').val();
                            let date = new Date(day);
                            calendar.gotoDate(date);
                            emp();
                            loadAttendance(date);
                        }
                    },
                    prevYear: {
                        click: function () {
                            let fY  = $('#sl-1 :last-child').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idY === fY) {
                                notifyError();
                            } else {
                                $('#sl-1 :nth-child(' + (idY + 2) + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (idM + 1) + ')').prop('selected', true).change();
                                $('#sl-3 :nth-child(2)').prop('selected', true).change();
                            }
                        }
                    },
                    nextYear: {
                        click: function () {
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idY === 1) {
                                notifyError();
                            } else {
                                $('#sl-1 :nth-child(' + idY + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (idM + 1) + ')').prop('selected', true).change();
                                $('#sl-3 :nth-child(2)').prop('selected', true).change();
                            }
                        }
                    },
                    prev    : {
                        click: function () {
                            let fY     = $('#sl-1 :last-child').index();
                            let idD    = sl3.children(':selected').index();
                            let idM    = sl2.children(':selected').index();
                            let idY    = sl1.children(':selected').index();
                            let slDate = sl3.children(':selected').val();
                            let fSun   = new Date(slDate).getDate();
                            if (idD === 1) {
                                if (idY === fY && idM === 12) {
                                    notifyError();
                                } else {
                                    if (fSun < 7) {
                                        if (idM === 12) {
                                            $('#sl-1 :nth-child(' + (idY + 2) + ')').prop('selected', true).change();
                                            $('#sl-2 :nth-child(2)').prop('selected', true).change();
                                        } else {
                                            $('#sl-2 :nth-child(' + (idM + 2) + ')').prop('selected', true).change();
                                        }
                                        $('#sl-3 :nth-last-child(2)').prop('selected', true).change();
                                    } else {
                                        if (idM === 1) {
                                            $('#sl-1 :nth-child(' + (idY + 2) + ')').prop('selected', true).change();
                                            $('#sl-2 :last-child').prop('selected', true).change();
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
                            let lW     = $('#sl-3 :last-child').index();
                            let idD    = sl3.children(':selected').index();
                            let idM    = sl2.children(':selected').index();
                            let idY    = sl1.children(':selected').index();
                            let slDate = sl3.children(':selected').val();
                            let lSun   = new Date(slDate).getDay();
                            if (idD === lW) {
                                if (idM === 1) {
                                    if (idY === 1) {
                                        notifyError();
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

            const keys       = ['Late_1', 'Late_2', 'OnTime', 'Early_1', 'Early_2', 'OffWork', 'Miss'];
            let workTime     = {
                    ...Object.fromEntries(
                        keys.map(key => [key, 0])
                    )
                },
                overTime     = {...workTime},
                offTime      = {...workTime},
                on_time      = '#00C67F',
                miss         = '#9299A0',
                off_work     = '#FF3C28',
                late_1       = '#F38C8C',
                late_2       = '#F57542',
                early_1      = '#9761ED',
                early_2      = '#8CA5FF',
                firstShift   = [],
                secondShift  = [],
                lastShift    = [],
                eventSource1 = [],
                num          = 9998,
                color_1,
                color_2,
                text_color,
                check_in,
                check_out;
            $.ajax({
                url     : '{{route('managers.get_shift_time')}}',
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

            let sl1 = $('#sl-1');
            let sl2 = $('#sl-2');
            let sl3 = $('#sl-3');
            $(".fc-prevYear-button")
                .before($('<button>')
                    .attr({
                        id   : 'confirm',
                        style: 'margin: 0 3px'
                    })
                    .addClass('btn btn-primary d-none')
                    .text('Confirm')
                )
                .before($('<button>')
                    .attr({
                        id   : 'back',
                        style: 'margin: 0 3px'
                    })
                    .addClass('btn btn-primary d-none')
                    .text('Back')
                )
            let back      = $("#back");
            let confirm   = $("#confirm");
            let confirmed = $("#confirmed");
            emp();

            let crYear = new Date(today).toISOString().slice(0, 4);
            for (let i = crYear; i >= 2020; i--) {
                sl1
                    .append($('<option>')
                        .attr('value', i)
                        .text(i)
                        .addClass('y-opt')
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
                    .addClass('m-opt')
                )
            }

            function loadAttendance(d) {
                let m      = getMon(d).toISOString().slice(0, 10);
                let s      = getSun(d).toISOString().slice(0, 10);
                let crTime = new Date(m).getTime();
                $.ajax({
                    url     : '{{route('managers.attendance_api')}}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        m: m,
                        s: s,
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
                        eventSource1 = [];
                        $('.div-name').remove()
                        let emp_types = response.length;
                        let e_num     = 0;
                        for (let k = 1; k < emp_types; k++) {
                            let emp_id  = 0;
                            let emp_num = response[k].length;
                            let nShift  = 0;
                            for (let i = 0; i < emp_num; i++) {
                                emp_id = response[k][i]['id'];
                                e_num++;
                                let dept_id  = response[k][i]['departments']['id'];
                                let dept     = response[k][i]['departments']['name'];
                                let role     = response[k][i]['roles']['name'];
                                let role_id  = response[k][i]['roles']['id'];
                                let emp_name = response[k][i]['fname'] + ' ' + response[k][i]['lname'];
                                emp_name += role === 'Manager' ? '*' : '';
                                let emp_role = role_id === 1 ? 2 : dept_id === 1 ? 3 : 1;
                                $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                    .append($('<div>')
                                        .addClass('text-center div-name')
                                        .append($('<a>')
                                            .append($('<b>')
                                                .addClass('emp_name text-center')
                                                .attr({
                                                    style          : 'font-size: 15px',
                                                    "data-id"      : emp_id,
                                                    "data-emp_role": emp_role,
                                                    "data-role"    : role,
                                                    "data-dept"    : dept,
                                                    "data-role_id" : role_id,
                                                })
                                                .text(emp_name)
                                            )
                                        )
                                    )
                                if (e_num % 2 === 0) {
                                    text_color = '#F5F5DC';
                                    $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child > :last-child').css('background', '#F0F8FF')
                                } else {
                                    text_color = '#000000';
                                }
                                let date   = m;
                                let length = response[k][i]['attendance'].length;
                                if (length === 0) {
                                    let crMon     = getMon(today).toISOString().slice(0, 10);
                                    let crDay     = new Date(td).getDay();
                                    crDay         = crDay === 0 ? 7 : crDay;
                                    let total_day = crMon === m ? crDay : 7;
                                    date          = getFullDate(m);
                                    if (td >= date) {
                                        for (let i = 1; i <= total_day; i++) {
                                            addEvent1(date)
                                            date = getNextDate(date);
                                        }
                                    }
                                } else {
                                    let default_date = m;
                                    for (let j = 0; j < length; j++) {
                                        let shift = response[k][i]['attendance'][j]['shift'];
                                        let date  = response[k][i]['attendance'][j]['date'];
                                        check_in  = response[k][i]['attendance'][j]['check_in'];
                                        check_out = response[k][i]['attendance'][j]['check_out'];
                                        let d1    = getDay(default_date);
                                        let d2    = getDay(date);
                                        d1        = d1 === 0 ? 7 : d1;
                                        d2        = d2 === 0 ? 7 : d2;
                                        if (j === 0) {
                                            addEvent1(date, default_date, shift)
                                            if (d1 < d2) {
                                                let off_date = m;
                                                for (let n = d1; n < d2; n++) {
                                                    addEvent1(off_date);
                                                    off_date = getNextDate(off_date)
                                                }
                                            }
                                        } else {
                                            addEvent1(date, default_date, shift, nShift);
                                            if (d1 !== d2) {
                                                if (d2 - d1 > 0) {
                                                    let offDate = getNextDate(default_date);
                                                    for (let n = d1 + 1; n < d2; n++) {
                                                        addEvent1(offDate);
                                                        offDate = getNextDate(offDate);
                                                    }
                                                }
                                            }
                                        }
                                        nShift       = shift;
                                        default_date = date;
                                        if (check_in !== null) {
                                            check_in = check_in.slice(0, 5);
                                        }
                                        if (check_out !== null) {
                                            check_out = check_out.slice(0, 5);
                                        }
                                        checkTime(check_in, check_out, shift, date);
                                        let title = check_in + Array(16).fill('\xa0').join('') + check_out;
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
                                        eventSource1.push(event);
                                        num--;
                                    }
                                    let l_date    = response[k][i]['attendance'][length - 1]['date'];
                                    let days      = getDay(l_date);
                                    let day       = getDay(new Date());
                                    let total_day = 7;
                                    days          = days === 0 ? 7 : days;
                                    day           = day === 0 ? 7 : day;
                                    if (days < total_day) {
                                        let date = getNextDate(l_date);
                                        if (crTime === tdTime) {
                                            total_day = day;
                                        }
                                        if (crTime <= tdTime) {
                                            addEvent1(l_date, '', 0, nShift);
                                        }
                                        for (let i = days + 1; i <= total_day; i++) {
                                            addEvent1(date);
                                            date = getNextDate(date);
                                        }
                                    }
                                }
                            }
                        }
                        changeCount();
                        calendar.addEventSource(eventSource1);
                        $(".emp_name").click(function () {
                            let name = $(this).text();
                            $('#emp_detail').text(name);
                            $('#sl-1, #sl-2, #sl-3, #department, .fc-button').addClass('d-none');
                            $('#back, #emp_detail').removeClass('d-none');

                            calendar.removeAllEvents();
                            del();
                            calendar.changeView('dayGridMonth');
                            let id       = $(this).data('id');
                            let emp_role = $(this).data('emp_role');
                            let role_id  = $(this).data('role_id');
                            let role     = $(this).data('role');
                            let dept     = $(this).data('dept');
                            let m        = sl2.children(':selected').text();
                            let y        = sl1.children(':selected').text();
                            let crD      = y + '-' + m;
                            let crTime   = new Date(crD).getTime();
                            let crDate   = new Date(td).getDate();
                            let td1      = getFullDate(new Date(new Date().setHours(7)).setDate(1));
                            let tdDate   = new Date(new Date().setHours(7)).setDate(1);
                            let tdMonth  = new Date(tdDate).getMonth();
                            let crDate1  = getFullDate(crD);
                            let tdDate1  = getFullDate(new Date(td1).setMonth(tdMonth - 1));
                            $.ajax({
                                url     : '{{route('managers.emp_attendance_api')}}',
                                type    : 'POST',
                                dataType: 'json',
                                data    : {
                                    id      : id,
                                    emp_role: emp_role,
                                    dept    : dept,
                                    role    : role,
                                    date    : crD
                                },
                            })
                                .done(function (response) {
                                    if (response[0] !== null) {
                                        confirm.prop('disabled', true);
                                        confirm.removeClass('btn-primary');
                                        confirm.addClass('btn-secondary');
                                    } else {
                                        confirm.prop('disabled', false);
                                        confirm.addClass('btn-primary');
                                        confirm.removeClass('btn-secondary');
                                    }
                                    let shift_num    = response[1].length;
                                    let default_date = getFullDate(crD);
                                    let total_day    = getDays(crD);
                                    let nShift       = 0;
                                    let e1           = firstShift['check_in_end'].split(':').map(x => parseFloat(x));
                                    let s1           = firstShift['check_out_start'].split(':').map(x => parseFloat(x));
                                    let e2           = secondShift['check_in_end'].split(':').map(x => parseFloat(x));
                                    let s2           = secondShift['check_out_start'].split(':').map(x => parseFloat(x));
                                    let e3           = lastShift['check_in_end'].split(':').map(x => parseFloat(x));
                                    let s3           = lastShift['check_out_start'].split(':').map(x => parseFloat(x));
                                    let S1           = s1[0] - e1[0] + (s1[1] - e1[1]) / 60;
                                    let S2           = s2[0] - e2[0] + (s2[1] - e2[1]) / 60;
                                    let S3           = s3[0] - e3[0] + (s3[1] - e3[1]) / 60;
                                    let WT           = S1 + S2;
                                    let WT1          = 0;
                                    let TT           = 0;
                                    let TT1          = 0;
                                    let TT2          = 0;
                                    Object.keys(workTime).forEach(key => {
                                        workTime[key] = 0;
                                    });
                                    Object.keys(overTime).forEach(key => {
                                        overTime[key] = 0;
                                    });
                                    Object.keys(offTime).forEach(key => {
                                        offTime[key] = 0;
                                    });
                                    eventSource1 = [];
                                    if (shift_num > 0) {
                                        let emp_id = response[1][0]['emp_id'];
                                        for (let i = 0; i < shift_num; i++) {
                                            num--;
                                            let shift = response[1][i]['shift'];
                                            let date  = response[1][i]['date'];
                                            check_in  = response[1][i]['check_in'];
                                            check_out = response[1][i]['check_out'];
                                            let d1    = getDate(default_date);
                                            let d2    = getDate(date);
                                            let sun   = getDay(date);
                                            let sun1  = getDay(default_date);
                                            if (i === 0) {
                                                addEvent1(date, crDate1, shift)
                                                if (d1 < d2) {
                                                    let off_date = crDate1;
                                                    for (let n = 1; n < d2; n++) {
                                                        addEvent1(off_date);
                                                        off_date = getNextDate(off_date)
                                                    }
                                                }
                                            } else {
                                                addEvent1(date, default_date, shift, nShift);
                                                if (d1 !== d2) {
                                                    if (d2 - d1 > 0) {
                                                        let off_date = getNextDate(default_date);
                                                        for (let i = d1 + 1; i < d2; i++) {
                                                            addEvent1(off_date);
                                                            off_date = getNextDate(off_date);
                                                        }
                                                    }
                                                }
                                            }
                                            if (d2 !== d1) {
                                                if (sun1 === 0) {
                                                    TT2 += WT1 / WT;
                                                } else {
                                                    let WTX = WT1 - WT;
                                                    if (WTX <= 0) {
                                                        TT += 1 + WTX / WT;
                                                    } else {
                                                        TT1 += WTX / WT;
                                                        TT += 1;
                                                    }
                                                }
                                                WT1 = 0;
                                            }
                                            WT1 += shift === 1 ? S1 : shift === 2 ? S2 : shift === 3 ? S3 : 0;
                                            if (i === shift_num - 1) {
                                                if (sun === 0) {
                                                    TT2 += WT1 / WT;
                                                } else {
                                                    let WTX = WT1 - WT;
                                                    if (WTX <= 0) {
                                                        TT += 1 + WTX / WT;
                                                    } else {
                                                        TT += 1;
                                                        TT1 += WTX / WT;
                                                    }
                                                }
                                            }
                                            default_date = date;
                                            if (check_in !== null) {
                                                check_in = check_in.slice(0, 5);
                                            }
                                            if (check_out !== null) {
                                                check_out = check_out.slice(0, 5);
                                            }
                                            checkTime(check_in, check_out, shift, date);
                                            nShift    = shift;
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
                                            eventSource1.push(event);
                                        }
                                        let l_date = response[1][shift_num - 1]['date'];
                                        let days   = getDate(l_date);
                                        if (days < total_day) {
                                            if (crTime === mTime) {
                                                total_day = crDate;
                                            }
                                            if (crTime <= mTime) {
                                                addEvent1(l_date, '', 0, nShift);
                                                for (let i = days + 1; i <= total_day; i++) {
                                                    let d = new Date(l_date);
                                                    d.setDate(i);
                                                    d        = new Date(d);
                                                    let date = getFullDate(d);
                                                    addEvent1(date);
                                                }
                                            }
                                        }
                                        if (tdDate1 === crDate1) {
                                            if (crDate <= 99) {
                                                let E1 = workTime['Early_1'] + overTime['Early_1'] + offTime['Early_1'];
                                                let E2 = workTime['Early_2'] + overTime['Early_2'] + offTime['Early_2'];
                                                let L1 = workTime['Late_1'] + overTime['Late_1'] + offTime['Late_1'];
                                                let L2 = workTime['Late_2'] + overTime['Late_2'] + offTime['Late_2'];
                                                let MS = workTime['Miss'] + overTime['Miss'] + offTime['Miss'];
                                                let X1 = TT;
                                                let X2 = TT + TT1;
                                                let X3 = TT + TT1 + TT2;
                                                if (X1 < 26) {
                                                    if (X2 < 26) {
                                                        if (X3 < 26) {
                                                            TT  = X3;
                                                            TT2 = 0;
                                                        } else if (X3 === 26) {
                                                            TT  = X3;
                                                            TT1 = 0;
                                                        } else {
                                                            TT  = 26;
                                                            TT2 = X3 - 26;
                                                        }
                                                        TT1 = 0;
                                                    } else if (X2 === 26) {
                                                        TT  = X2;
                                                        TT1 = 0;
                                                    }
                                                } else if (X1 > 26) {
                                                    TT = 26;
                                                    TT1 += X1 - 26;
                                                }
                                                confirm.removeClass('d-none')
                                                    .attr({
                                                        "data-toggle": 'modal',
                                                        "data-target": "#success-alert-modal",
                                                    });
                                                confirmed.attr({
                                                    "data-id"          : emp_id,
                                                    "data-workday"     : TT,
                                                    "data-over_workday": TT1,
                                                    "data-off_workday" : TT2,
                                                    "data-miss"        : MS,
                                                    "data-early1"      : E1,
                                                    "data-early2"      : E2,
                                                    "data-late1"       : L1,
                                                    "data-late2"       : L2,
                                                    "data-dept"        : dept,
                                                    "data-role"        : role,
                                                    "data-role_id"     : role_id,
                                                })
                                            }
                                        }
                                    } else {
                                        if (mTime === crTime) {
                                            total_day = crDate;
                                        }
                                        if (crTime <= mTime) {
                                            let d = new Date(default_date);
                                            for (let i = 1; i <= total_day; i++) {
                                                d.setDate(i);
                                                d        = new Date(d);
                                                let date = getFullDate(d);
                                                addEvent1(date);
                                            }
                                        }
                                    }
                                    calendar.addEventSource(eventSource1);
                                    changeCount();
                                })
                        })
                    })
            }

            loadDate(new Date(), 1);
            sl1.change(function () {
                loadWeek();
            })

            sl2.change(function () {
                loadWeek();
            })

            sl3.change(function () {
                goTo.click();
            })

            confirmed.click(function () {
                let cf      = $(this);
                let m       = sl2.children(':selected').text();
                let y       = sl1.children(':selected').text();
                let id      = cf.data('id');
                let role    = cf.data('role');
                let dept    = cf.data('dept');
                let role_id = cf.data('role_id');
                let TT      = cf.data('workday');
                let TT1     = cf.data('over_workday');
                let TT2     = cf.data('off_workday');
                let MS      = cf.data('miss');
                let E1      = cf.data('early1');
                let E2      = cf.data('early2');
                let L1      = cf.data('late1');
                let L2      = cf.data('late2');
                $.ajax({
                    url     : '{{route('managers.salary_api')}}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        emp_id       : id,
                        role_name    : role,
                        dept_name    : dept,
                        role_id      : role_id,
                        work_day     : TT,
                        over_work_day: TT1,
                        off_work_day : TT2,
                        miss         : MS,
                        early_1      : E1,
                        early_2      : E2,
                        late_1       : L1,
                        late_2       : L2,
                        month        : m,
                        year         : y,
                    },
                })
                cf.removeData()
                back.click();
                $('#cancel').click()
            })

            back.click(function () {
                calendar.changeView('dayGridWeek');
                $('#sl-1, #sl-2, #sl-3, .fc-button').removeClass('d-none');
                $('#back, #emp_detail, #confirm, .fc-goto-button').addClass('d-none');
                goTo.click();
            })

            function loadDate(d, status = 0) {
                d        = new Date(d);
                let dd   = d.getDay();
                let cd   = d.getDate();
                let cm   = d.getMonth() + 1;
                let cy   = d.getFullYear();
                let m    = sl2.children(':selected').val();
                let y    = sl1.children(':selected').val();
                dd       = dd === 0 ? 7 : dd;
                let sd   = cd - dd + 7;
                let days = getDays(d);
                if (sd >= days) {
                    sd = days;
                }
                let cM = new Date(cy, cm - 1, sd).setHours(7);
                cM     = getFullDate(cM);

                cm !== m && sl1.val(cy).change();
                cy !== y && sl2.val(cm).change();
                loadWeek();
                sl3.val(cM).change();
                if (status === 1) {
                    goTo.click();
                }
            }

            function changeCount() {
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
            }

            function del() {
                $('table.fc-scrollgrid-sync-table tbody tr > :first-child').remove();
                $('table.fc-col-header thead tr:first-child > :first-child').remove();
            }

            function emp() {
                $('table.fc-col-header > thead > tr:first-child')
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
                                .attr('id', 'emp-name')
                                .text('Name')
                            )
                        )
                    );
            }

            function loadWeek() {
                sl3.empty();
                sl3.append($('<option>').text('Day'));
                let j     = 0,
                    num   = 0,
                    ar    = '',
                    arr1  = [],
                    year  = sl1.children(':selected').val(),
                    month = sl2.children(':selected').val(),
                    days  = new Date(year, month, 0).getDate(),
                    fd    = new Date(year, month - 1, 1).getDay();
                month     = month < 10 ? '0' + month : month;
                let pMon  = month < 11 ? '0' + (month - 1) : month === 1 ? '12' : month - 1,
                    nMon  = month < 9 ? '0' + (month - 0 + 1) : month === 12 ? '01' : month - 0 + 1;
                if (fd !== 0) {
                    let mon = new Date(year, month - 1, 2 - fd).getDate();
                    mon     = mon === 1 ? '01' : mon;
                    mon += '/' + pMon;
                    arr1.push(mon);
                } else {
                    let mon = new Date(year, month - 1, -6).getDate(),
                        sun = '01/' + month;
                    mon += '/' + pMon;
                    arr1.push(mon, sun);
                    num++;
                    let val = new Date(year, month - 1, 1).toISOString().slice(0, 10);
                    ar      = arr1[0] + '-' + arr1[1];
                    sl3.append($('<option>')
                        .val(val)
                        .text(ar)
                        .addClass('d-opt')
                    )
                    arr1 = [];
                }
                for (let i = 2; i <= days; i++) {
                    j     = i < 10 ? '0' + i : i;
                    let n = new Date(year, month - 1, i).getDay();
                    if (n === 1) {
                        let data = j + '/' + month;
                        arr1.push(data);
                    } else if (n === 0) {
                        let data = j + '/' + month,
                            val  = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                        num++;
                        arr1.push(data);
                        ar = arr1[0] + '-' + arr1[1];
                        sl3.append($('<option>')
                            .val(val)
                            .text(ar)
                            .addClass('d-opt')
                        )
                        arr1 = [];
                    } else {
                        if (i === days) {
                            num++;
                            let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10),
                                sun = new Date(year, month, 6 - i).getDate();
                            fd      = new Date(year, month, i).getDay();
                            sun     = '0' + sun + '/' + nMon;
                            arr1.push(sun);
                            ar = arr1[0] + '-' + arr1[1];
                            sl3.append($('<option>')
                                .val(val)
                                .text(ar)
                                .addClass('d-opt')
                            )
                            arr1 = [];
                        }
                    }
                }
            }

            function getSun(d) {
                d        = new Date(d);
                let day  = d.getDay(),
                    diff = d.getDate() + (day === 0 ? 0 : 7 - day);
                return new Date(d.setDate(diff));
            }

            function getMon(d) {
                d        = new Date(d);
                let day  = d.getDay(),
                    diff = d.getDate() - day + (day === 0 ? -6 : 1);
                return new Date(d.setDate(diff));
            }

            function getPreDate(d) {
                d       = new Date(d);
                let num = d.getDate()
                d       = d.setDate(num - 1)
                return new Date(d).toISOString().slice(0, 10);
            }

            function getNextDate(d) {
                d       = new Date(d);
                let num = d.getDate()
                d       = d.setDate(num + 1)
                return new Date(d).toISOString().slice(0, 10);
            }

            function getFullDate(d) {
                return new Date(d).toISOString().slice(0, 10);
            }

            function getDate(d) {
                return new Date(d).getDate();
            }

            function getDay(d) {
                return new Date(d).getDay();
            }

            function getDays(d) {
                d         = new Date(d);
                let m     = d.getMonth() + 1;
                let lDate = new Date(d.setDate(1));
                let l     = new Date(lDate.setMonth(m));
                d         = new Date(l.setDate(0));
                return new Date(d).getDate();
            }


            function checkSunday(date) {
                return new Date(date).getDay() === 0;
            }

            function addEvent1(date, defaultDate = '', currentShift = 0, nextShift = 0) {
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
                            eventSource1.push(event);
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
                    eventSource1.push(event);
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