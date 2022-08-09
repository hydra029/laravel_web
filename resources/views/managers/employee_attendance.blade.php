@extends('layout.master')
@include('managers.menu')
@push('css')
	<link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<link href="{{ asset('css/style.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<style>
        .fc-daygrid-event {
            margin: 0;
        }

        #external-events, #external-events > .fc-event {
            cursor: pointer !important;
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

        .event-0 {
            text-align: left;
        }

        .event-1 {
            background: #9761ed;
        }

        .event-2 {
            background: #8ca5ff;
        }

        .event-3 {
            background: #00c67f;
        }

        .event-4 {
            background: #f07171;
        }

        .event-5 {
            background: #f57542;
        }

        .event-6 {
            background: #9299a0;
        }

        .event-7 {
            background: #f03e44;
        }

        .emp-name {
            margin: 8px 0;
        }

        .E11, .E21, .OT1, .L11, .L21, .OW1, .MS1,
        .E12, .E22, .OT2, .L12, .L22, .OW2, .MS2,
        .E13, .E23, .OT3, .L13, .L23, .OW3, .MS3 {
            float: right;
            text-align: center;
            padding: 0;
        }

        #table_salary {
            margin: 5px 7px;
            border: 1px solid #3788d8;
            border-radius: 5px !important;
            font-size: 13px;
            text-align: center;
            width: 94%;
            cursor: default;
        }

        #table_salary tr > th {
            border: 1px solid #3788d8;
            height: 32px;
            padding: 0 !important;
            width: 50% !important;
        }

        .type {
            width: 20%;
            text-align: center;
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
                    <span class="text-left">
                        Early 1:
                    </span>
					<span class="E13 col-2">
                    </span>
					<span class="E12 col-2">
                    </span>
					<span class="E11 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-2'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        Early 2:
                    </span>
					<span class="E23 col-2">
                    </span>
					<span class="E22 col-2">
                    </span>
					<span class="E21 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-3'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        On Time:
                    </span>
					<span class="OT3 col-2">
                    </span>
					<span class="OT2 col-2">
                    </span>
					<span class="OT1 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-4'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        Late 1:
                    </span>
					<span class="L13 col-2">
                    </span>
					<span class="L12 col-2">
                    </span>
					<span class="L11 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-5'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        Late 2:
                    </span>
					<span class="L23 col-2">
                    </span>
					<span class="L22 col-2">
                    </span>
					<span class="L21 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-6'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        Miss:
                    </span>
					<span class="MS3 col-2">
                    </span>
					<span class="MS2 col-2">
                    </span>
					<span class="MS1 col-2">
                    </span>
				</div>
			</div>
			<div class='fc-event fc-h-event event-7'>
				<div class='fc-event-main tc event-0'>
                    <span>
                        Off Work:
                    </span>
					<span class="OW3 col-2">
                    </span>
					<span class="OW2 col-2">
                    </span>
					<span class="OW1 col-2">
                    </span>
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
	<script src="{{ asset('js/cute-alert.js' )}}"></script>
	<script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const calendarEl = document.getElementById('calendar');
            let td           = getFullDate(new Date());
            let today        = new Date(new Date(td).setHours(7));
            let mTime        = new Date(new Date(new Date(td).setHours(7)).setDate(1)).getTime();
            let tdTime       = new Date(new Date(getMon(td)).setHours(7)).getTime();
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
                editable                 : true,
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
                                $.toast({
                                    heading        : 'Something went wrong',
                                    text           : 'There is no more data available',
                                    icon           : 'info',
                                    position       : 'top-right',
                                    hideAfter      : 2000,
                                    allowToastClose: false,
                                });
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
                                $.toast({
                                    heading        : 'Something went wrong',
                                    text           : 'There is no more data available',
                                    icon           : 'info',
                                    position       : 'top-right',
                                    hideAfter      : 2000,
                                    allowToastClose: false,
                                });
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
                                    $.toast({
                                        heading        : 'Something went wrong',
                                        text           : 'There is no more data available',
                                        icon           : 'info',
                                        position       : 'top-right',
                                        hideAfter      : 2000,
                                        allowToastClose: false,
                                    });
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
                                        $.toast({
                                            heading        : 'Something went wrong',
                                            text           : 'There is no more data available',
                                            icon           : 'info',
                                            position       : 'top-right',
                                            hideAfter      : 2000,
                                            allowToastClose: false,
                                        });
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


            calendar.render();
            $(".fc-goto-button")
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
            let back    = $("#back");
            let confirm = $("#confirm");
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
                let e      = [];
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
                        $('.div-name').remove()
                        let text_color;
                        let emp_types = response.length;
                        let e_num     = 0;
                        let num       = 9998;

                        let E11 = 0;
                        let E21 = 0;
                        let OT1 = 0;
                        let L11 = 0;
                        let L21 = 0;
                        let MS1 = 0;
                        let OW1 = 0;
                        let E12 = 0;
                        let E22 = 0;
                        let OT2 = 0;
                        let L12 = 0;
                        let L22 = 0;
                        let MS2 = 0;
                        let OW2 = 0;
                        let E13 = 0;
                        let E23 = 0;
                        let OT3 = 0;
                        let L13 = 0;
                        let L23 = 0;
                        let OW3 = 0;
                        let MS3 = 0;

                        let on_time  = '#00c67f';
                        let miss     = '#9299a0';
                        let off_work = '#f03e44';
                        let late_1   = '#f07171';
                        let late_2   = '#f57542';
                        let early_1  = '#9761ed';
                        let early_2  = '#8ca5ff';
                        let color_1  = off_work;
                        let color_2  = off_work;

                        let check_in_1_start    = response[0][0]['check_in_start'].slice(0, 5);
                        let check_in_1_end      = response[0][0]['check_in_end'].slice(0, 5);
                        let check_in_1_late_1   = response[0][0]['check_in_late_1'].slice(0, 5);
                        let check_in_1_late_2   = response[0][0]['check_in_late_2'].slice(0, 5);
                        let check_out_1_start   = response[0][0]['check_out_start'].slice(0, 5);
                        let check_out_1_end     = response[0][0]['check_out_end'].slice(0, 5);
                        let check_out_1_early_1 = response[0][0]['check_out_early_1'].slice(0, 5);
                        let check_out_1_early_2 = response[0][0]['check_out_early_2'].slice(0, 5);
                        let check_in_2_start    = response[0][1]['check_in_start'].slice(0, 5);
                        let check_in_2_end      = response[0][1]['check_in_end'].slice(0, 5);
                        let check_in_2_late_1   = response[0][1]['check_in_late_1'].slice(0, 5);
                        let check_in_2_late_2   = response[0][1]['check_in_late_2'].slice(0, 5);
                        let check_out_2_start   = response[0][1]['check_out_start'].slice(0, 5);
                        let check_out_2_end     = response[0][1]['check_out_end'].slice(0, 5);
                        let check_out_2_early_1 = response[0][1]['check_out_early_1'].slice(0, 5);
                        let check_out_2_early_2 = response[0][1]['check_out_early_2'].slice(0, 5);
                        let check_in_3_start    = response[0][2]['check_in_start'].slice(0, 5);
                        let check_in_3_end      = response[0][2]['check_in_end'].slice(0, 5);
                        let check_in_3_late_1   = response[0][2]['check_in_late_1'].slice(0, 5);
                        let check_in_3_late_2   = response[0][2]['check_in_late_2'].slice(0, 5);
                        let check_out_3_start   = response[0][2]['check_out_start'].slice(0, 5);
                        let check_out_3_end     = response[0][2]['check_out_end'].slice(0, 5);
                        let check_out_3_early_1 = response[0][2]['check_out_early_1'].slice(0, 5);
                        let check_out_3_early_2 = response[0][2]['check_out_early_2'].slice(0, 5);
                        for (let k = 1; k < emp_types; k++) {
                            let emp_id  = 0;
                            let emp_num = response[k].length;
                            for (let i = 0; i < emp_num; i++) {
                                emp_id = response[k][i]['id'];
                                e_num++;
                                let dept_id  = response[k][i]['departments']['id'];
                                let dept     = response[k][i]['departments']['name'];
                                let role     = response[k][i]['roles']['name'];
                                let role_id  = response[k][i]['roles']['id'];
                                let emp_name = response[k][i]['fname'] + ' ' + response[k][i]['lname'];
                                if (role === 'Manager') {
                                    emp_name += '*';
                                }
                                let emp_role = 1;
                                if (role_id === 1) {
                                    emp_role = 2;
                                } else {
                                    if (dept_id === 1) {
                                        emp_role = 3;
                                    }
                                }
                                if (e_num % 2 === 0) {
                                    text_color = '#F5F5DC';
                                    $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                        .append($('<div>')
                                            .attr('style', 'height: 82.005px; padding: 22px 0; background: #F0F8FF; cursor: pointer;')
                                            .addClass('text-center div-name')
                                            .append($('<a>')
                                                .append($('<b>')
                                                    .addClass('emp-name text-center')
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
                                } else {
                                    text_color = '#000000';
                                    $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                        .append($('<div>')
                                            .attr('style', 'height: 82.09px; padding: 22px 0; cursor: pointer;')
                                            .addClass('text-center div-name')
                                            .append($('<a>')
                                                .append($('<b>')
                                                    .addClass('emp-name text-center')
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
                                }
                                let date   = m;
                                let length = response[k][i]['attendance'].length;
                                if (length === 0) {
                                    let total_day = 7;
                                    let crMon     = getMon(today).toISOString().slice(0, 10);
                                    if (crMon === m) {
                                        total_day = new Date(td).getDay();
                                    }
                                    date = getFullDate(m);
                                    for (let i = 1; i <= total_day; i++) {
                                        addEvent(3, num, date, e);
                                        let sun = getDay(date);
                                        num -= 1;
                                        if (sun === 0) {
                                            OW3 += 6;
                                        } else {
                                            OW1 += 4;
                                            OW2 += 2;
                                        }
                                        date = getNextDate(date);
                                    }
                                } else {
                                    let s_num        = 1;
                                    let default_date = m;
                                    for (let j = 0; j < length; j++) {
                                        let shift     = response[k][i]['attendance'][j]['shift'];
                                        let date      = response[k][i]['attendance'][j]['date'];
                                        let check_in  = response[k][i]['attendance'][j]['check_in'];
                                        let check_out = response[k][i]['attendance'][j]['check_out'];
                                        let sun       = getDay(date);
                                        let d1        = getDay(default_date);
                                        let d2        = getDay(date);
                                        if (d1 === 0) {
                                            d1 = 7;
                                        }
                                        if (d2 === 0) {
                                            d2 = 7;
                                        }
                                        if (j === 0) {
                                            if (shift === 2) {
                                                addEvent(1, num, date, e);
                                                num--;
                                                if (sun === 0) {
                                                    OW3 += 2;
                                                } else {
                                                    OW1 += 2;
                                                }
                                            }
                                            if (shift === 3) {
                                                addEvent(2, num, date, e);
                                                num -= 2;
                                                if (sun === 0) {
                                                    OW3 += 4;
                                                } else {
                                                    OW1 += 4;
                                                }
                                            }
                                            if (d1 < d2) {
                                                let off_date = m;
                                                for (let n = 1; n < d2; n++) {
                                                    addEvent(3, num, off_date, e);
                                                    num -= 3;
                                                    OW1 += 4;
                                                    OW2 += 2;
                                                    off_date = getNextDate(off_date)
                                                }
                                            }
                                        }
                                        if (d1 === d2) {
                                            if (shift === 3) {
                                                if (s_num === 2) {
                                                    addEvent(1, num, date, e);
                                                }
                                                num--;
                                            }
                                        }
                                        if (d1 !== d2 && j > 0) {
                                            let dx = d2 - d1;
                                            if (dx > 0) {
                                                let off_date = getNextDate(default_date);
                                                for (let n = d1 + 1; n < d2; n++) {
                                                    addEvent(3, num, off_date, e);
                                                    num -= 3;
                                                    OW1 += 4;
                                                    OW2 += 2;
                                                    off_date = getNextDate(off_date)
                                                }
                                            }
                                            let sun = getDay(date)
                                            if (shift === 1) {
                                                if (s_num === 2) {
                                                    addEvent(2, num, default_date, e);
                                                    num -= 2;
                                                    OW1 += 2;
                                                    OW2 += 2;

                                                }
                                                if (s_num === 3) {
                                                    addEvent(1, num, default_date, e);
                                                    num--;
                                                    OW1 += 2;

                                                }
                                            }
                                            if (shift === 2) {
                                                if (s_num === 2) {
                                                    addEvent(2, num, default_date, e)
                                                    num -= 2;
                                                    addEvent(1, num, date, e)
                                                    num--;
                                                    if (sun === 0) {
                                                        OW3 += 2;
                                                        OW1 += 2;
                                                        OW2 += 2;
                                                    } else {
                                                        OW1 += 4;
                                                        OW2 += 2;
                                                    }
                                                }
                                                if (s_num === 3) {
                                                    addEvent(1, num, default_date, e)
                                                    num--;
                                                    addEvent(1, num, date, e)
                                                    num--;
                                                    if (sun === 0) {
                                                        OW3 += 2;
                                                        OW2 += 2;
                                                    } else {
                                                        OW1 += 2;
                                                        OW2 += 2;
                                                    }
                                                }
                                                if (s_num === 1) {
                                                    addEvent(1, num, date, e)
                                                    num--;
                                                    if (sun === 0) {
                                                        OW3 += 2;
                                                    } else {
                                                        OW1 += 2;
                                                    }
                                                }
                                            }
                                            if (shift === 3) {
                                                if (s_num === 2) {
                                                    addEvent(2, num, default_date, e)
                                                    num -= 2;
                                                    addEvent(2, num, date, e)
                                                    num -= 2;
                                                    if (sun === 0) {
                                                        OW3 += 4;
                                                        OW1 += 2;
                                                        OW2 += 2;
                                                    } else {
                                                        OW1 += 6;
                                                        OW2 += 2;
                                                    }
                                                }
                                                if (s_num === 3) {
                                                    addEvent(1, num, default_date, e)
                                                    num--;
                                                    addEvent(2, num, date, e)
                                                    num -= 2;
                                                    if (sun === 0) {
                                                        OW3 += 4;
                                                        OW2 += 2;
                                                    } else {
                                                        OW1 += 4;
                                                        OW2 += 2;
                                                    }
                                                }
                                                if (s_num === 1) {
                                                    addEvent(2, num, date, e)
                                                    num--;
                                                    if (sun === 0) {
                                                        OW3 += 4;
                                                    } else {
                                                        OW1 += 4;
                                                    }
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
                                        if (shift === 1) {
                                            if (check_in >= check_in_1_start && check_in <= check_in_1_end) {
                                                check_in = Array(10).fill('\xa0').join('');
                                                color_1  = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT1++;
                                                }
                                            } else if (check_in <= check_in_1_late_1) {
                                                color_1 = late_2;
                                                if (sun === 0) {
                                                    L23++;
                                                } else {
                                                    L21++;
                                                }
                                            } else if (check_in <= check_in_1_late_2) {
                                                color_1 = late_1;
                                                if (sun === 0) {
                                                    L13++;
                                                } else {
                                                    L11++;
                                                }
                                            }
                                            if (check_out >= check_out_1_start && check_out <= check_out_1_end) {
                                                check_out = Array(10).fill('\xa0').join('');
                                                color_2   = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT1++;
                                                }
                                            } else if (check_out >= check_out_1_early_1) {
                                                color_2 = early_2;
                                                if (sun === 0) {
                                                    E23++;
                                                } else {
                                                    E21++;
                                                }
                                            } else if (check_out >= check_out_1_early_2) {
                                                color_2 = early_1;
                                                if (sun === 0) {
                                                    E13++;
                                                } else {
                                                    E11++;
                                                }
                                            }
                                            s_num = 2
                                        } else if (shift === 2) {
                                            if (check_in >= check_in_2_start && check_in <= check_in_2_end) {
                                                check_in = Array(10).fill('\xa0').join('');
                                                color_1  = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT1++;
                                                }
                                            } else if (check_in <= check_in_2_late_1) {
                                                color_1 = late_2;
                                                if (sun === 0) {
                                                    L23++;
                                                } else {
                                                    L21++;
                                                }
                                            } else if (check_in <= check_in_2_late_2) {
                                                color_1 = late_1;
                                                if (sun === 0) {
                                                    L13++;
                                                } else {
                                                    L11++;
                                                }
                                            }
                                            if (check_out >= check_out_2_start && check_out <= check_out_2_end) {
                                                check_out = Array(10).fill('\xa0').join('');
                                                color_2   = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT1++;
                                                }
                                            } else if (check_out >= check_out_2_early_1) {
                                                color_2 = early_2;
                                                if (sun === 0) {
                                                    E23++;
                                                } else {
                                                    E21++;
                                                }
                                            } else if (check_out >= check_out_2_early_2) {
                                                color_2 = early_1;
                                                if (sun === 0) {
                                                    E13++;
                                                } else {
                                                    E11++;
                                                }
                                            }
                                            s_num = 3;
                                        } else {
                                            if (check_in >= check_in_3_start && check_in <= check_in_3_end) {
                                                check_in = Array(10).fill('\xa0').join('');
                                                color_1  = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT2++;
                                                }
                                            } else if (check_in <= check_in_3_late_1) {
                                                color_1 = late_2;
                                                if (sun === 0) {
                                                    L23++;
                                                } else {
                                                    L22++;
                                                }
                                            } else if (check_in <= check_in_3_late_2) {
                                                color_1 = late_1;
                                                if (sun === 0) {
                                                    L13++;
                                                } else {
                                                    L12++;
                                                }
                                            }
                                            if (check_out >= check_out_3_start && check_out <= check_out_3_end) {
                                                check_out = Array(10).fill('\xa0').join('');
                                                color_2   = on_time;
                                                if (sun === 0) {
                                                    OT3++;
                                                } else {
                                                    OT2++;
                                                }
                                            } else if (check_out >= check_out_3_early_1) {
                                                color_2 = early_2;
                                                if (sun === 0) {
                                                    E23++;
                                                } else {
                                                    E22++;
                                                }
                                            } else if (check_out >= check_out_3_early_2) {
                                                color_2 = early_1;
                                                if (sun === 0) {
                                                    E13++;
                                                } else {
                                                    E12++;
                                                }
                                            }
                                            s_num = 1;
                                        }
                                        if (check_in === null) {
                                            check_in = Array(10).fill('\xa0').join('');
                                            color_1  = miss;
                                            if (sun === 0) {
                                                MS3++;
                                            } else {
                                                if (shift === 3) {
                                                    MS2++;
                                                } else {
                                                    MS1++;
                                                }
                                            }
                                        }
                                        if (check_out === null) {
                                            check_out = Array(10).fill('\xa0').join('');
                                            color_2   = miss;
                                            if (sun === 0) {
                                                MS3++;
                                            } else {
                                                if (shift === 3) {
                                                    MS2++;
                                                } else {
                                                    MS1++;
                                                }
                                            }
                                        }
                                        let title = check_in + Array(20).fill('\xa0').join('') + check_out;
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
                                        e.push(event);
                                        num--;
                                    }
                                    let l_date    = response[k][i]['attendance'][length - 1]['date'];
                                    let days      = getDay(l_date);
                                    let day       = getDay(new Date());
                                    if (days < day) {
                                        let date = getFullDate(today);
                                        addEvent(3,num,date,e);
                                        num -= 3;
                                    }
                                    let total_day = 7;
                                    if (days === 0) {
                                        days = 7;
                                    }
                                    if (days < total_day) {
                                        let date = getNextDate(l_date);
                                        if (crTime === tdTime) {
                                            total_day = days - 1;
                                        }
                                        if (s_num === 2) {
                                            addEvent(2, num, l_date, e);
                                            num -= 2;
                                            if (days === 0) {
                                                OW3 += 4;
                                            } else {
                                                OW1 += 2;
                                                OW2 += 2;
                                            }
                                        } else if (s_num === 3) {
                                            addEvent(1, num, l_date, e);
                                            num -= 1;
                                            if (days === 0) {
                                                OW3 += 2;
                                            } else {
                                                OW2 += 2;
                                            }
                                        }
                                        for (let i = 1; i < total_day; i++) {
                                            addEvent(3, num, date, e);
                                            num -= 3;
                                            let sun = getDay(date);
                                            if (sun === 0) {
                                                OW3 += 6;
                                            } else {
                                                OW1 += 4;
                                                OW2 += 2;
                                            }
                                            date = getNextDate(date);
                                        }
                                    }
                                }
                            }
                            $('.E11').text(E11);
                            $('.E21').text(E21);
                            $('.OT1').text(OT1);
                            $('.L11').text(L11);
                            $('.L21').text(L21);
                            $('.MS1').text(MS1);
                            $('.OW1').text(OW1);
                            $('.E12').text(E12);
                            $('.E22').text(E22);
                            $('.OT2').text(OT2);
                            $('.L12').text(L12);
                            $('.L22').text(L22);
                            $('.MS2').text(MS2);
                            $('.OW2').text(OW2);
                            $('.E13').text(E13);
                            $('.E23').text(E23);
                            $('.OT3').text(OT3);
                            $('.L13').text(L13);
                            $('.L23').text(L23);
                            $('.OW3').text(OW3);
                            $('.MS3').text(MS3);
                        }
                        calendar.addEventSource(e);
                        $(".emp-name").click(function () {
                            let E11 = 0;
                            let E21 = 0;
                            let OT1 = 0;
                            let L11 = 0;
                            let L21 = 0;
                            let MS1 = 0;
                            let OW1 = 0;
                            let E12 = 0;
                            let E22 = 0;
                            let OT2 = 0;
                            let L12 = 0;
                            let L22 = 0;
                            let MS2 = 0;
                            let OW2 = 0;
                            let E13 = 0;
                            let E23 = 0;
                            let OT3 = 0;
                            let L13 = 0;
                            let L23 = 0;
                            let OW3 = 0;
                            let MS3 = 0;

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
                            let e        = [];
                            let crDate   = new Date(td).getDate();
                            let td1      = getFullDate(new Date(new Date().setHours(7)).setDate(1));
                            let tdDate   = new Date(new Date().setHours(7)).setDate(1);
                            let tdMonth  = new Date(tdDate).getMonth();
                            let crDate1  = getFullDate(new Date(crD));
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
                                    let s_num        = 1;
                                    let default_date = getFullDate(crD);
                                    let total_day    = getDays(crD);

                                    let e1  = check_in_1_end.split(':').map(x => parseFloat(x));
                                    let s1  = check_out_1_start.split(':').map(x => parseFloat(x));
                                    let e2  = check_in_2_end.split(':').map(x => parseFloat(x));
                                    let s2  = check_out_2_start.split(':').map(x => parseFloat(x));
                                    let e3  = check_in_3_end.split(':').map(x => parseFloat(x));
                                    let s3  = check_out_3_start.split(':').map(x => parseFloat(x));
                                    let S1  = s1[0] - e1[0] + (s1[1] - e1[1]) / 60;
                                    let S2  = s2[0] - e2[0] + (s2[1] - e2[1]) / 60;
                                    let S3  = s3[0] - e3[0] + (s3[1] - e3[1]) / 60;
                                    let WT  = S1 + S2;
                                    let WT1 = 0;
                                    let TT  = 0;
                                    if (shift_num > 0) {
                                        let emp_id = response[1][0]['emp_id'];
                                        for (let i = 0; i < shift_num; i++) {
                                            num--;
                                            let shift     = response[1][i]['shift'];
                                            let date      = response[1][i]['date'];
                                            let check_in  = response[1][i]['check_in'];
                                            let check_out = response[1][i]['check_out'];
                                            let d1        = getDate(default_date);
                                            let d2        = getDate(date);
                                            let sun       = getDay(date);
                                            let sun1      = getDay(default_date);
                                            if (i === 0) {
                                                if (shift === 2) {
                                                    addEvent(1, num, date, e);
                                                    num--;
                                                    if (sun === 0) {
                                                        OW3 += 2;
                                                    } else {
                                                        OW1 += 2;
                                                    }
                                                }
                                                if (shift === 3) {
                                                    addEvent(2, num, date, e);
                                                    num -= 2;
                                                    if (sun === 0) {
                                                        OW3 += 4;
                                                    } else {
                                                        OW1 += 4;
                                                    }
                                                }
                                                if (d1 < d2) {
                                                    let off_date = getFullDate(crD);
                                                    for (let n = 1; n < d2; n++) {
                                                        addEvent(3, num, off_date, e);
                                                        num -= 3;
                                                        OW1 += 4;
                                                        OW2 += 2;
                                                        off_date = getNextDate(off_date)
                                                    }
                                                }
                                            }
                                            if (d1 === d2) {
                                                if (shift === 3) {
                                                    if (s_num === 2) {
                                                        addEvent(1, num, date, e);
                                                    }
                                                    num--;
                                                }
                                            }
                                            if (d2 !== d1) {
                                                if (sun1 === 0) {
                                                    TT += 2 * WT1 / WT;
                                                } else {
                                                    let WTX = WT1 - WT;
                                                    if (WTX <= 0) {
                                                        TT += 1 + WTX / WT;
                                                    } else {
                                                        TT += 1 + 1.5 * WTX / WT;
                                                    }
                                                }
                                                WT1 = 0;
                                                if (i > 0) {
                                                    let dx = d2 - d1;
                                                    if (dx > 0) {
                                                        let off_date = getNextDate(default_date);
                                                        for (let n = d1 + 1; n < d2; n++) {
                                                            let sun = getDay(off_date)
                                                            addEvent(3, num, off_date, e);
                                                            num -= 3;
                                                            if (sun === 0) {
                                                                OW3 += 6;
                                                            } else {
                                                                OW1 += 4;
                                                                OW2 += 2;
                                                            }
                                                            off_date = getNextDate(off_date)
                                                        }
                                                    }
                                                    if (shift === 1) {
                                                        if (s_num === 2) {
                                                            addEvent(2, num, default_date, e);
                                                            num -= 2;
                                                            if (sun1 === 0) {
                                                                OW3 += 4;
                                                            } else {
                                                                OW1 += 2;
                                                                OW2 += 2;
                                                            }
                                                        }
                                                        if (s_num === 3) {
                                                            addEvent(1, num, default_date, e);
                                                            num--;
                                                            if (sun1 === 0) {
                                                                OW3 += 2;
                                                            } else {
                                                                OW2 += 2;
                                                            }
                                                        }
                                                    }
                                                    if (shift === 2) {
                                                        if (s_num === 2) {
                                                            addEvent(2, num, default_date, e)
                                                            num -= 2;
                                                            addEvent(1, num, date, e)
                                                            num--;
                                                            if (sun === 0) {
                                                                OW3 += 2;
                                                                OW2 += 2;
                                                                OW1 += 2;
                                                            } else if (sun1 === 0) {
                                                                OW1 += 2;
                                                                OW3 += 4;
                                                            } else {
                                                                OW1 += 4;
                                                                OW2 += 2;
                                                            }
                                                        }
                                                        if (s_num === 3) {
                                                            addEvent(1, num, default_date, e)
                                                            num--;
                                                            addEvent(1, num, date, e)
                                                            num--;
                                                            if (sun === 0) {
                                                                OW3 += 2;
                                                                OW2 += 2;
                                                            } else if (sun1 === 0) {
                                                                OW1 += 2;
                                                                OW3 += 2;
                                                            } else {
                                                                OW1 += 2;
                                                                OW2 += 2;
                                                            }
                                                        }
                                                        if (s_num === 1) {
                                                            addEvent(1, num, date, e)
                                                            num--;
                                                            if (sun === 0) {
                                                                OW3 += 2;
                                                            } else {
                                                                OW1 += 2;
                                                            }
                                                        }
                                                    }
                                                    if (shift === 3) {
                                                        if (s_num === 2) {
                                                            addEvent(2, num, default_date, e)
                                                            num -= 2;
                                                            addEvent(2, num, date, e)
                                                            num -= 2;
                                                            if (sun === 0) {
                                                                OW3 += 4;
                                                                OW2 += 4;
                                                            } else if (sun1 === 0) {
                                                                OW1 += 4;
                                                                OW3 += 4;
                                                            } else {
                                                                OW1 += 6;
                                                                OW2 += 2;
                                                            }
                                                        }
                                                        if (s_num === 3) {
                                                            addEvent(1, num, default_date, e)
                                                            num--;
                                                            addEvent(2, num, date, e)
                                                            num -= 2;
                                                            if (sun === 0) {
                                                                OW3 += 4;
                                                                OW2 += 2;
                                                            } else if (sun1 === 0) {
                                                                OW1 += 4;
                                                                OW3 += 2;
                                                            } else {
                                                                OW1 += 4;
                                                                OW2 += 2;
                                                            }
                                                        }
                                                        if (s_num === 1) {
                                                            addEvent(2, num, date, e)
                                                            num--;
                                                            if (sun === 0) {
                                                                OW3 += 4;
                                                            } else {
                                                                OW1 += 4;
                                                            }
                                                        }
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
                                            if (shift === 1) {
                                                WT1 += S1;
                                                if (check_in >= check_in_1_start && check_in <= check_in_1_end) {
                                                    check_in = Array(10).fill('\xa0').join('');
                                                    color_1  = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT1++;
                                                    }
                                                } else if (check_in <= check_in_1_late_1) {
                                                    color_1 = late_2;
                                                    if (sun === 0) {
                                                        L23++;
                                                    } else {
                                                        L21++;
                                                    }
                                                } else if (check_in <= check_in_1_late_2) {
                                                    color_1 = late_1;
                                                    if (sun === 0) {
                                                        L13++;
                                                    } else {
                                                        L11++;
                                                    }
                                                }
                                                if (check_out >= check_out_1_start && check_out <= check_out_1_end) {
                                                    check_out = Array(10).fill('\xa0').join('');
                                                    color_2   = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT1++;
                                                    }
                                                } else if (check_out >= check_out_1_early_1) {
                                                    color_2 = early_2;
                                                    if (sun === 0) {
                                                        E23++;
                                                    } else {
                                                        E21++;
                                                    }
                                                } else if (check_out >= check_out_1_early_2) {
                                                    color_2 = early_1;
                                                    if (sun === 0) {
                                                        E13++;
                                                    } else {
                                                        E11++;
                                                    }
                                                }
                                                s_num = 2
                                            } else if (shift === 2) {
                                                WT1 += S2;
                                                if (check_in >= check_in_2_start && check_in <= check_in_2_end) {
                                                    check_in = Array(10).fill('\xa0').join('');
                                                    color_1  = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT1++;
                                                    }
                                                } else if (check_in <= check_in_2_late_1) {
                                                    color_1 = late_2;
                                                    if (sun === 0) {
                                                        L23++;
                                                    } else {
                                                        L21++;
                                                    }
                                                } else if (check_in <= check_in_2_late_2) {
                                                    color_1 = late_1;
                                                    if (sun === 0) {
                                                        L13++;
                                                    } else {
                                                        L11++;
                                                    }
                                                }
                                                if (check_out >= check_out_2_start && check_out <= check_out_2_end) {
                                                    check_out = Array(10).fill('\xa0').join('');
                                                    color_2   = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT1++;
                                                    }
                                                } else if (check_out >= check_out_2_early_1) {
                                                    color_2 = early_2;
                                                    if (sun === 0) {
                                                        E23++;
                                                    } else {
                                                        E21++;
                                                    }
                                                } else if (check_out >= check_out_2_early_2) {
                                                    color_2 = early_1;
                                                    if (sun === 0) {
                                                        E13++;
                                                    } else {
                                                        E11++;
                                                    }
                                                }
                                                s_num = 3;
                                            } else if (shift === 3) {
                                                WT1 += S3;
                                                if (check_in >= check_in_3_start && check_in <= check_in_3_end) {
                                                    check_in = Array(10).fill('\xa0').join('');
                                                    color_1  = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT2++;
                                                    }
                                                } else if (check_in <= check_in_3_late_1) {
                                                    color_1 = late_2;
                                                    if (sun === 0) {
                                                        L23++;
                                                    } else {
                                                        L22++;
                                                    }
                                                } else if (check_in <= check_in_3_late_2) {
                                                    color_1 = late_1;
                                                    if (sun === 0) {
                                                        L13++;
                                                    } else {
                                                        L12++;
                                                    }
                                                }
                                                if (check_out >= check_out_3_start && check_out <= check_out_3_end) {
                                                    check_out = Array(10).fill('\xa0').join('');
                                                    color_2   = on_time;
                                                    if (sun === 0) {
                                                        OT3++;
                                                    } else {
                                                        OT2++;
                                                    }
                                                } else if (check_out >= check_out_3_early_1) {
                                                    color_2 = early_2;
                                                    if (sun === 0) {
                                                        E23++;
                                                    } else {
                                                        E22++;
                                                    }
                                                } else if (check_out >= check_out_3_early_2) {
                                                    color_2 = early_1;
                                                    if (sun === 0) {
                                                        E13++;
                                                    } else {
                                                        E12++;
                                                    }
                                                }
                                                s_num = 1;
                                            }
                                            if (i === shift_num - 1) {
                                                if (sun === 0) {
                                                    TT += 2 * WT1 / WT;
                                                } else {
                                                    let WTX = WT1 - WT;
                                                    if (WTX <= 0) {
                                                        TT += 1 + WTX / WT;
                                                    } else {
                                                        TT += 1 + 1.5 * WTX / WT;
                                                    }
                                                }
                                            }
                                            if (check_in === null) {
                                                check_in = Array(10).fill('\xa0').join('');
                                                color_1  = miss;
                                                if (sun === 0) {
                                                    MS3++;
                                                } else {
                                                    if (shift === 3) {
                                                        MS2++;
                                                    } else {
                                                        MS1++;
                                                    }
                                                }
                                            }
                                            if (check_out === null) {
                                                check_out = Array(10).fill('\xa0').join('');
                                                color_2   = miss;
                                                if (sun === 0) {
                                                    MS3++;
                                                } else {
                                                    if (shift === 3) {
                                                        MS2++;
                                                    } else {
                                                        MS1++;
                                                    }
                                                }
                                            }
                                            let title = check_in + Array(20).fill('\xa0').join('') + check_out;
                                            let color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)';
                                            let event = {
                                                id        : num,
                                                title     : title,
                                                start     : date,
                                                allDay    : true,
                                                overlap   : false,
                                                background: color,
                                            }
                                            e.push(event);
                                        }
                                        let l_date = response[1][shift_num - 1]['date'];
                                        let days   = getDate(l_date);
                                        if (days < total_day) {
                                            if (crTime === mTime) {
                                                total_day = crDate;
                                            }
                                            if (crTime <= mTime) {
                                                if (s_num === 2) {
                                                    addEvent(2, num, l_date, e);
                                                    num -= 2;
                                                    if (getDay(l_date) === 0) {
                                                        OW3 += 4;
                                                    } else {
                                                        OW1 += 2;
                                                        OW2 += 2;
                                                    }
                                                } else if (s_num === 3) {
                                                    addEvent(1, num, l_date, e);
                                                    num -= 1;
                                                    if (getDay(l_date) === 0) {
                                                        OW3 += 2;
                                                    } else {
                                                        OW2 += 2;
                                                    }
                                                }
                                                for (let i = days + 1; i <= total_day; i++) {
                                                    let d = new Date(l_date);
                                                    d.setDate(i);
                                                    d        = new Date(d);
                                                    let date = getFullDate(d);
                                                    addEvent(3, num, date, e);
                                                    num -= 3;
                                                    let sun = getDay(date);
                                                    if (sun === 0) {
                                                        OW3 += 6;
                                                    } else {
                                                        OW1 += 4;
                                                        OW2 += 2;
                                                    }
                                                }
                                            }
                                        }
                                        if (tdDate1 === crDate1) {
                                            if (crDate <= 99) {
                                                let E1 = E11 + E12 + E13;
                                                let E2 = E21 + E22 + E23;
                                                let L1 = L11 + L12 + L13;
                                                let L2 = L21 + L22 + L23;
                                                let MS = MS1 + MS2 + MS3;
                                                confirm.removeClass('d-none');
                                                confirm.attr({
                                                    "data-id"     : emp_id,
                                                    "data-workday": TT,
                                                    "data-miss"   : MS,
                                                    "data-early1" : E1,
                                                    "data-early2" : E2,
                                                    "data-late1"  : L1,
                                                    "data-late2"  : L2,
                                                    "data-dept"   : dept,
                                                    "data-role"   : role,
                                                    "data-role_id": role_id,
                                                })
                                            }
                                        }
                                    } else {
                                        if (mTime === crTime) {
                                            total_day = crDate;
                                        }
                                        if (crTime <= mTime) {
                                            for (let i = 1; i <= total_day; i++) {
                                                let d = new Date(default_date);
                                                d.setDate(i);
                                                d        = new Date(d);
                                                let date = getFullDate(d);
                                                addEvent(3, num, date, e);
                                                num -= 3;
                                                let sun = getDay(date);
                                                if (sun === 0) {
                                                    OW3 += 6;
                                                } else {
                                                    OW1 += 4;
                                                    OW2 += 2;
                                                }
                                            }
                                        }
                                    }
                                    calendar.addEventSource(e);
                                    $('.E11').text(E11);
                                    $('.E21').text(E21);
                                    $('.OT1').text(OT1);
                                    $('.L11').text(L11);
                                    $('.L21').text(L21);
                                    $('.MS1').text(MS1);
                                    $('.OW1').text(OW1);
                                    $('.E12').text(E12);
                                    $('.E22').text(E22);
                                    $('.OT2').text(OT2);
                                    $('.L12').text(L12);
                                    $('.L22').text(L22);
                                    $('.MS2').text(MS2);
                                    $('.OW2').text(OW2);
                                    $('.E13').text(E13);
                                    $('.E23').text(E23);
                                    $('.OT3').text(OT3);
                                    $('.L13').text(L13);
                                    $('.L23').text(L23);
                                    $('.OW3').text(OW3);
                                    $('.MS3').text(MS3);
                                })
                        })
                    })
            }

            loadDate(td);
            sl1.change(function () {
                loadWeek();
            })

            sl2.change(function () {
                loadWeek();
            })

            sl3.change(function () {
                $(".fc-goto-button").click();
            })

            confirm.click(function () {
                let cf = $(this);
                cuteAlert({
                    type      : "success",
                    title     : "Confirmation",
                    message   : "Be careful !!!",
                    buttonText: "Okay",
                }).then((e) => {
                    if (e === 'ok') {
                        let m       = sl2.children(':selected').text();
                        let y       = sl1.children(':selected').text();
                        let ID      = cf.data('id');
                        let role    = cf.data('role');
                        let dept    = cf.data('dept');
                        let role_id = cf.data('role_id');
                        let TT      = cf.data('workday');
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
                                ID     : ID,
                                role   : role,
                                dept   : dept,
                                role_id: role_id,
                                TT     : TT,
                                MS     : MS,
                                E1     : E1,
                                E2     : E2,
                                L1     : L1,
                                L2     : L2,
                                m      : m,
                                y      : y,
                            },
                        })
                        back.click();
                    }
                })
                $('.alert-img').attr('src', 'img/question.svg');
            })

            back.click(function () {
                calendar.changeView('dayGridWeek');
                $('#sl-1, #sl-2, #sl-3, .fc-button').removeClass('d-none');
                $('#back, #emp_detail, #confirm, .fc-goto-button').addClass('d-none');
                $(".fc-goto-button").click();
            })

            function loadDate(d) {
                d      = new Date(d);
                let dd = d.getDay();
                let cd = d.getDate();
                let cm = d.getMonth() + 1;
                let cy = d.getFullYear();
                let m  = sl2.children(':selected').val();
                let y  = sl1.children(':selected').val();
                let cM = new Date(cy, cm - 1, cd - dd + 8).toISOString().slice(0, 10);
                if (cm !== m) {
                    sl1.val(cy).change();
                }
                if (cy !== y) {
                    sl2.val(cm).change();
                }
                loadWeek();
                sl3.val(cM).change();
                $(".fc-goto-button").click();
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
                let j     = 0;
                let num   = 0;
                let ar    = '';
                let arr1  = [];
                let year  = sl1.children(':selected').val();
                let month = sl2.children(':selected').val();
                let days  = new Date(year, month, 0).getDate();
                let fd    = new Date(year, month - 1, 1).getDay();
                let pMon  = month - 1;
                let nMon  = month - 0 + 1;
                if (month < 10) {
                    month = '0' + month;
                }
                if (month < 11) {
                    pMon = '0' + pMon;
                } else if (month === 1) {
                    pMon = '12';
                }
                if (month < 9) {
                    nMon = '0' + nMon;
                } else if (month === 12) {
                    nMon = '01';
                }
                if (fd !== 0) {
                    let mon = new Date(year, month - 1, 2 - fd).getDate();
                    if (mon === 1) {
                        mon = '01';
                    }
                    mon = mon + '/' + pMon;
                    arr1.push(mon);
                } else {
                    let mon = new Date(year, month - 1, -6).getDate();
                    mon += '/' + pMon;
                    let sun = '01/' + month;
                    arr1.push(mon);
                    arr1.push(sun);
                    num++;
                    let val = new Date(year, month - 1, 1).toISOString().slice(0, 10);
                    ar      = arr1[0] + '-' + arr1[1];
                    sl3.append($('<option>')
                        .attr({
                            value: val,
                            id   : 'W' + num
                        })
                        .text(ar)
                        .addClass('d-opt')
                    )
                    arr1 = [];
                }
                for (let i = 2; i <= days; i++) {
                    j = i;
                    if (i < 10) {
                        j = '0' + i;
                    }
                    let n = new Date(year, month - 1, i).getDay();
                    if (n === 1) {
                        let data = j + '/' + month;
                        arr1.push(data)
                    } else if (n === 0) {
                        let data = j + '/' + month;
                        num++;
                        let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                        arr1.push(data);
                        ar = arr1[0] + '-' + arr1[1];
                        sl3.append($('<option>')
                            .attr({
                                value: val,
                                id   : 'W' + num
                            })
                            .text(ar)
                            .addClass('d-opt')
                        )
                        arr1 = [];
                    } else {
                        if (i === days) {
                            num++;
                            let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                            fd      = new Date(year, month, i).getDay();
                            let sun = new Date(year, month, 6 - i).getDate();
                            sun     = '0' + sun + '/' + nMon;
                            arr1.push(sun);
                            ar = arr1[0] + '-' + arr1[1];
                            sl3.append($('<option>')
                                .attr({
                                    value: val,
                                    id   : 'W' + num
                                })
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

            function addEvent(x, n, d, e) {
                for (let i = 0; i < x; i++) {
                    let event = {
                        id        : n,
                        start     : d,
                        allDay    : true,
                        overlap   : false,
                        background: '#f03e44',
                    }
                    e.push(event);
                    n--;
                }
                return e;
            }

            function getDays(d) {
                d     = new Date(d);
                let m = d.getMonth() + 1;
                let l = new Date(d.setMonth(m));
                d     = new Date(l.setDate(0));
                return new Date(d).getDate();
            }
        })
	</script>
@endpush