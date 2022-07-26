@extends('layout.master')
@include('ceo.menu')
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
                customButtons: {
                    today: {
                        text: 'Today',
                        click: function () {
                            let date = new Date();
                            loadDate(date);
                        }
                    },
                    goto: {
                        text: 'Go to',
                        click: function () {
                            calendar.removeAllEvents();
                            del();
                            let day = sl3.children(':selected').val();
                            let date = new Date(day);
                            calendar.gotoDate(date);
                            emp();
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
                                    heading: 'Something went wrong',
                                    text: 'There is no more data available',
                                    icon: 'info',
                                    position: 'top-right',
                                    hideAfter: 2000,
                                });
                            } else {
                                $('#sl-1 :nth-child(' + idY + ')').prop('selected', true).change();
                                $('#sl-2 :nth-child(' + (idM + 1) + ')').prop('selected', true).change();
                                $('#sl-3 :nth-child(2)').prop('selected', true).change();
                            }
                        }
                    },
                    prev: {
                        click: function () {
                            let fY = $('#sl-1 :last-child').index();
                            let idD = sl3.children(':selected').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            let slDate = sl3.children(':selected').val();
                            let fSun = new Date(slDate).getDate();
                            console.log(fSun);
                            if (idD === 1) {
                                if (idY === fY && idM === 12) {
                                    $.toast({
                                        heading: 'Something went wrong',
                                        text: 'There is no more data available',
                                        icon: 'info',
                                        position: 'top-right',
                                        hideAfter: 2000,
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
                    next: {
                        click: function () {
                            let lW = $('#sl-3 :last-child').index();
                            let idD = sl3.children(':selected').index();
                            let idM = sl2.children(':selected').index();
                            let idY = sl1.children(':selected').index();
                            let slDate = sl3.children(':selected').val();
                            let lSun = new Date(slDate).getDay();
                            if (idD === lW) {
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
                    id: 'emp_detail',
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
                .before($('<select>')
                    .attr({
                        id: 'department',
                        style: 'margin: 0 3px'
                    })
                    .append($('<option>')
                        .text('Department')
                        .attr('value', 'all')
                    ))
                .before($('<button>')
                    .attr({
                        id: 'back',
                        style: 'margin: 0 3px'
                    })
                    .addClass('btn btn-primary d-none')
                    .text('Back')
                )
            let dept = $('#department');
            let back = $("#back");
            emp();
            loadAttendance(today);

            $.ajax({
                url: '{{route('ceo.department_api')}}',
                type: 'GET',
                dataType: 'json',
            })
                .done(function (response) {
                    let num = response.length;
                    for (let i = 0; i < num; i++) {
                        dept.append($('<option>')
                            .attr('value', response[i]['id'])
                            .text(response[i]['name'])
                            .addClass('m-opt')
                        )
                    }
                })

            let crYear = new Date().toISOString().slice(0, 4);
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
                let dept_id = dept.children(':selected').val();
                let m = getMon(d).toISOString().slice(0, 10);
                let s = getSun(d).toISOString().slice(0, 10);
                $.ajax({
                    url: '{{route('ceo.attendance_api')}}',
                    type: 'POST',
                    dataType: 'json',
                    data: {m: m, s: s, dept_id: dept_id},
                })
                    .done(function (response) {
                        let emp_id = 0;
                        let e_num = 0;
                        let num = 9998;
                        let text_color;
                        let eventSource = [];
                        let emp_types = response.length;
                        for (let k = 0; k < emp_types; k++) {
                            let emp_num = response[k].length;
                            for (let i = 0; i < emp_num; i++) {
                                let length = response[k][i]['attendance'].length;
                                for (let j = 0; j < length; j++) {
                                    let date = response[k][i]['attendance'][j]['date'];
                                    date = new Date(date);
                                    let emp_name = response[k][i]['fname'] + " " + response[k][i]['lname'];
                                    let emp_dept = response[k][i]['departments']['name'];
                                    if (k === 0) {
                                        emp_dept += '*';
                                    }
                                    num--;
                                    let emp_role = response[k][i]['attendance'][j]['emp_role'];
                                    let check_in = response[k][i]['attendance'][j]['check_in'].slice(0, 5);
                                    let check_out = response[k][i]['attendance'][j]['check_out'].slice(0, 5);
                                    let check_in_start = response[k][i]['attendance'][j]['shifts']['check_in_start'].slice(0, 5);
                                    let check_in_end = response[k][i]['attendance'][j]['shifts']['check_in_end'].slice(0, 5);
                                    let check_in_late_1 = response[k][i]['attendance'][j]['shifts']['check_in_late_1'].slice(0, 5);
                                    let check_in_late_2 = response[k][i]['attendance'][j]['shifts']['check_in_late_2'].slice(0, 5);
                                    let check_out_start = response[k][i]['attendance'][j]['shifts']['check_out_start'].slice(0, 5);
                                    let check_out_end = response[k][i]['attendance'][j]['shifts']['check_out_end'].slice(0, 5);
                                    let check_out_early_1 = response[k][i]['attendance'][j]['shifts']['check_out_early_1'].slice(0, 5);
                                    let check_out_early_2 = response[k][i]['attendance'][j]['shifts']['check_out_early_2'].slice(0, 5);
                                    let title = check_in + Array(14).fill('\xa0').join('') + check_out;
                                    let color_1 = '#F03E44';
                                    let color_2 = '#F03E44';

                                    if (check_in >= check_in_start && check_in <= check_in_end) {
                                        color_1 = '#00C67F';
                                    } else if (check_in > check_in_end && check_in <= check_in_late_1) {
                                        color_1 = '#F07171';
                                    } else if (check_in > check_in_late_1 && check_in <= check_in_late_2) {
                                        color_1 = '#F57542';
                                    }

                                    if (check_out >= check_out_start && check_out <= check_out_end) {
                                        color_2 = '#00C67F';
                                    } else if (check_out >= check_out_early_1 && check_out < check_out_start) {
                                        color_2 = '#8CA5FF';
                                    } else if (check_out >= check_out_early_2 && check_out < check_out_early_1) {
                                        color_2 = '#9761ED';
                                    }

                                    let color = 'linear-gradient(to right, ' + color_1 + ' 50%,' + color_2 + ' 50%)';
                                    if (emp_id !== response[k][i]['attendance'][j]['emp_id']) {
                                        emp_id = response[k][i]['attendance'][j]['emp_id'];
                                        e_num++;
                                        if (e_num % 2 === 0) {
                                            text_color = '#000000';
                                            $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                                .append($('<div>')
                                                    .attr('style', 'height: 82.005px; padding: 22px 0; background: #F0F8FF')
                                                    .addClass('text-center div-name')
                                                    .append($('<a>')
                                                        .append($('<b>')
                                                            .addClass('emp-name text-center')
                                                            .attr({
                                                                style: 'font-size: 15px',
                                                                "data-value": emp_id + "-" + emp_role,
                                                            })
                                                            .text(emp_name)
                                                        )
                                                        .append('<br>')
                                                        .append($('<p>')
                                                            .addClass('emp-dept text-center')
                                                            .attr({
                                                                style: 'font-size: 15px',
                                                            })
                                                            .text(emp_dept)
                                                        )
                                                    )
                                                )
                                        } else {
                                            text_color = '#F5F5DC';
                                            $('table.fc-scrollgrid-sync-table tbody tr:first-child > :first-child > :first-child')
                                                .append($('<div>')
                                                    .attr('style', 'height: 82.09px; padding: 22px 0')
                                                    .addClass('text-center div-name')
                                                    .append($('<a>')
                                                        .append($('<b>')
                                                            .addClass('emp-name text-center')
                                                            .attr({
                                                                style: 'font-size: 15px',
                                                                "data-value": emp_id + "-" + emp_role,
                                                            })
                                                            .text(emp_name)
                                                        )
                                                        .append('<br>')
                                                        .append($('<p>')
                                                            .addClass('emp-dept text-center')
                                                            .attr({
                                                                style: 'font-size: 15px',
                                                            })
                                                            .text(emp_dept)
                                                        )
                                                    )
                                                )
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
                            }
                        }
                        $(".emp-name").click(function () {
                            let name = $(this).text();
                            let dept = $(this).parent().find('.emp-dept').text();
                            let text = name + ' - ' + dept;
                            $('#emp_detail').text(text);
                            $('#sl-1, #sl-2, #sl-3, #department, .fc-button').addClass('d-none');
                            $('#back, #emp_detail').removeClass('d-none');
                            calendar.removeAllEvents();
                            del();
                            calendar.changeView('dayGridMonth');
                            let data = $(this).attr('data-value');
                            data = data.split('-');
                            let id = data[0];
                            let role = data[1];
                            let m = sl2.children(':selected').text();
                            let y = sl1.children(':selected').text();
                            let date = y + '-' + m;
                            $.ajax({
                                url: '{{route('ceo.emp_attendance_api')}}',
                                type: 'POST',
                                dataType: 'json',
                                data: {id: id, role: role, date: date},
                            })
                                .done(function (response) {
                                    let num = 9998;
                                    let emp_num = response.length;
                                    for (let i = 0; i <= emp_num; i++) {
                                        s
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
                        });
                        calendar.addEventSource(eventSource);
                    })
            }

            let d = calendar.getDate();
            loadDate(d);
            sl1.change(function () {
                loadWeek();
                $('#sl-3 :nth-child(2)').prop('selected', true);
                $(".fc-goto-button").click();
            })

            sl2.change(function () {
                loadWeek();
                $('#sl-3 :nth-child(2)').prop('selected', true);
                $(".fc-goto-button").click();
            })

            sl3.change(function () {
                $(".fc-goto-button").click();
            })

            dept.change(function () {
                calendar.removeAllEvents();
                del();
                let date = calendar.getDate();
                calendar.gotoDate(date);
                emp();
                loadAttendance(date);
            })

            back.click(function () {
                calendar.removeAllEvents();
                calendar.changeView('dayGridWeek');
                $('#sl-1, #sl-2, #sl-3, #department, .fc-button').removeClass('d-none');
                $('#back, #emp_detail').addClass('d-none');
                emp();
                loadAttendance(today);
            })

            function loadDate(d) {
                let dd = d.getDay();
                let cd = d.getDate();
                let cm = d.getMonth() + 1;
                let cy = d.getFullYear();
                let m = sl2.children(':selected').val();
                let y = sl1.children(':selected').val();
                let cM = new Date(cy, cm - 1, cd - dd + 8).toISOString().slice(0, 10);
                if (cm !== m) {
                    sl1.val(cy).change();
                }
                if (cy !== y) {
                    sl2.val(cm).change();
                }
                $.when(loadWeek()).then(sl3.val(cM).change());
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
                                    id: 'emp_name'
                                })
                                .text('Name')
                            )
                        )
                    );
            }

            function loadWeek() {
                sl3.empty();
                sl3.append($('<option>').text('Day'));
                let j = 0;
                let num = 0;
                let ar = '';
                let arr1 = [];
                let year = sl1.children(':selected').val();
                let month = sl2.children(':selected').val();
                let days = new Date(year, month, 0).getDate();
                let fd = new Date(year, month - 1, 1).getDay();
                let pMon = month - 1;
                let nMon = month - 0 + 1;
                if (month < 10) {
                    month = '0' + month;
                }
                if (pMon < 10 && pMon > 0) {
                    pMon = '0' + pMon;
                } else if (pMon === 0) {
                    pMon = 12;
                }
                if (nMon < 10) {
                    nMon = '0' + nMon;
                } else if (nMon >= 12) {
                    nMon = '01';
                }
                if (fd !== 0) {
                    let mon = new Date(year, month - 1, 2 - fd).getDate();
                    if (mon === 1) {
                        mon = '01';
                    }
                    mon = mon + '/' + pMon;
                    arr1.push(mon);
                }
                for (let i = 2; i <= days; i++) {
                    j = i;
                    if (i < 10) {
                        j = '0' + i;
                    }
                    let n = new Date(year, month - 1, i).getDay();
                    let data = j + '/' + month;
                    if (n === 1) {
                        arr1.push(data)
                    } else if (n === 0) {
                        num++;
                        let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                        arr1.push(data);
                        ar = arr1[0] + '-' + arr1[1];
                        sl3.append($('<option>')
                            .attr({
                                value: val,
                                id: 'W' + num
                            })
                            .text(ar)
                            .addClass('d-opt')
                        )
                        arr1 = [];
                    } else if (n !== 0 && i === days) {
                        num++;
                        let val = new Date(year, month - 1, i + 1).toISOString().slice(0, 10);
                        fd = new Date(year, month, i).getDay();
                        let sun = new Date(year, month, 6 - i).getDate();
                        sun = '0' + sun + '/' + nMon;
                        arr1.push(sun);
                        ar = arr1[0] + '-' + arr1[1];
                        sl3.append($('<option>')
                            .attr({
                                value: val,
                                id: 'W' + num
                            })
                            .text(ar)
                            .addClass('d-opt')
                        )
                        arr1 = [];
                    }
                }
            }

            function getSun(d) {
                d = new Date(d);
                let day = d.getDay(),
                    diff = d.getDate() + (day === 0 ? 0 : 7 - day);
                return new Date(d.setDate(diff));
            }

            function getMon(d) {
                d = new Date(d);
                let day = d.getDay(),
                    diff = d.getDate() - day + (day === 0 ? -6 : 1);
                return new Date(d.setDate(diff));
            }

            function loadEmpDate(d) {
                let cm = d.getMonth() + 1;
                let cy = d.getFullYear();
                sl1.val(cy).change();
                sl2.val(cm).change();
            }

        })
    </script>
@endpush


