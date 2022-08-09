@extends('layout.master')
@include('accountants.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
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
            let tdTime       = new Date(today.setDate(1)).getTime();
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
                            let year  = sl1.children(':selected').val();
                            let month = sl2.children(':selected').val();
                            if (month < 10) {
                                month = '0' + month;
                            }
                            let gDate = year + '-' + month + '-01';
                            let date  = new Date(gDate);
                            calendar.gotoDate(date);
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
                            }
                        }
                    },
                    prev    : {
                        click: function () {
                            let fY  = $('#sl-1 :last-child').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            if (idM === 12) {
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
                                    $('#sl-2 :nth-child(2)').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (idM + 2) + ')').prop('selected', true).change();
                            }
                        }
                    },
                    next    : {
                        click: function () {
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
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
                                    $('#sl-1 :nth-child(' + (idY) + ')').prop('selected', true).change();
                                    $('#sl-2 :last-child').prop('selected', true).change();
                                }
                            } else {
                                $('#sl-2 :nth-child(' + (idM) + ')').prop('selected', true).change();
                            }
                        }
                    }
                },
                eventDidMount            : function (info) {
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
                }
                sl2.append($('<option>')
                        .attr('value', i)
                        .text(j)
                        .addClass('m-opt')
                )
            }

            loadDate(new Date());

            function loadAttendance(d) {
                let f      = getFDay(d).toISOString().slice(0, 10);
                let l      = getLDay(d).toISOString().slice(0, 10);
                let crTime = new Date(f).getTime();
                let num    = 9998;
                let e      = [];
                let crDate = new Date(td).getDate();
                $.ajax({
                    url     : '{{ route('accountants.history_api') }}',
                    type    : 'POST',
                    dataType: 'json',
                    data    : {
                        f: f,
                        l: l
                    },
                })
                        .done(function (response) {
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

                                    let shift_num    = response[1].length;
                                    let default_date = f;
                                    let s_num        = 1;
                                    let total_day    = getDays(f);
                                    if (shift_num > 0) {
                                        for (let i = 0; i < shift_num; i++) {
                                            num--;
                                            let shift     = response[1][i]['shift'];
                                            let date      = response[1][i]['date'];
                                            let check_in  = response[1][i]['check_in'];
                                            let check_out = response[1][i]['check_out'];

                                            let d1   = getDate(default_date);
                                            let d2   = getDate(date);
                                            let sun  = getDay(date);
                                            let sun1 = getDay(default_date);
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
                                                    let off_date = f;
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
                                            } else if (shift === 3) {
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
                                            }
                                            e.push(event);
                                        }
                                        let l_date = response[1][shift_num - 1]['date'];
                                        let days   = getDate(l_date);
                                        let crDate = new Date().getDate();
                                        if (days < total_day) {
                                            if (crTime === tdTime) {
                                                total_day = crDate;
                                            }
                                            if (crTime <= tdTime) {
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
                                    } else {
                                        if (tdTime === crTime) {
                                            total_day = crDate;
                                        }
                                        if (crTime <= tdTime) {
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
                                }
                        )
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
                d     = new Date(d);
                let m = d.getMonth() + 1;
                let l = new Date(d.setMonth(m));
                return new Date(l.setDate(0));
            }

            function getDays(d) {
                d     = new Date(d);
                let m = d.getMonth() + 1;
                let l = new Date(d.setMonth(m));
                d     = new Date(l.setDate(0));
                return new Date(d).getDate();
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

            function getDate(d) {
                return new Date(d).getDate();
            }

            function getFullDate(d) {
                return new Date(d).toISOString().slice(0, 10);
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

            function getDay(d) {
                return new Date(d).getDay();
            }
        });
    </script>
@endpush
