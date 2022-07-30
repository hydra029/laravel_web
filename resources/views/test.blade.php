@extends('layout.master')
@include('ceo.menu')
@section('content')
    <label>
        <input class="inp" type="text" name="master" placeholder="12:20" value="12:20">
        <input class="inp-2" type="text" name="master" placeholder="11:20" value="11:20">
    </label>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            let inp = $(':input');
            inp.on('keydown', function (e) {
                e.preventDefault();
                let value = $(this).val();
                let placeholder = $(this).attr('placeholder');
                let len = value.length;
                let val = value.split('');
                if (e.keyCode === 8) {
                    if (len === 3) {
                        value = val[0] + val[1];
                    } else {
                        value = '';
                        for (let i = 0; i < len - 2; i++) {
                            value += val[i];
                        }
                    }
                } else if (e.key >= 0 && e.key <= 9) {
                    if (len === 2) {
                        value += ':' + e.key;
                    } else if (len === 5) {
                        placeholder = $(this).val();
                        $(this).attr('placeholder', placeholder);
                        value = e.key;
                    } else {
                        value += e.key;
                    }
                } else {
                    const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d)$/;
                    let value = $(this).val();
                    if (value === '' || value.match(time_regex) === false) {
                        let placeholder = $(this).attr('placeholder');
                        $(this).val(placeholder);
                    }
                    inp.blur();
                }
                $(this).val(value);
            })
                .on('click', function () {
                    $(this).val('');
                })
                .blur(function () {
                    const time_regex = /^([0-1]\d|2[0-3]):([0-5]\d)$/;
                    let value = $(this).val();
                    if (value === '' || !value.match(time_regex)) {
                        let placeholder = $(this).attr('placeholder');
                        $(this).val(placeholder);
                    }
                })
        })
    </script>
@endpush


