@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="fines col-12">
        <div class="col-12 p-2 border border-1 border-light">
            <div >
                <h4 class="tittle-pay-rate ">Fines</h4>
            </div>
        </div>
        <div class="col-12 p-2 border border-0 border-light fines-details">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Fines</th>
                    <th>Deduction</th>
                    <th class="text-center">Action</th>
                </thead>
                <tbody class="roles_list_body">

                @foreach ($fines as $each)
                <tr>
                        <form class="change-fines" method="POST" action="">
                            @csrf
                        <td class="col-1 text-danger">
                        <div class="">
                        {{ $each->id }}
                        <input type="hidden" class="inp-fines-id" name="id" value=" {{ $each->id }}" />
                        </div>
                        </td>
                        <td class="col-3">
                        <div class=" fines_name">
                            {{ $each->name }}
                        </div>
                        <input type="text" class="inp-fines-name d-none" name="name" value="{{ $each->name }}">
                        </td>
                        <td class="col-3">
                        <div class=" fines_time">
                            {{ $each->fines_time }}
                        </div>
                        <input type="number" class="inp-fines-time d-none"  name="fines" value="{{ $each->fines }}">
                        </td>
                        <td class="col-3">
                        <div class=" deduction_detail">
                            {{ $each->deduction_detail }}
                        </div>
                        <input type="text" class="inp-deduction d-none"  name="deduction"  pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$"  data-type="currency"  value="{{ $each->deduction }}">
                        </td>
                        <td class="col-2">
                        <div align="center">
                        <i type="button" class="btn-change-fines fa-solid fa-pen btn-edit-role text-warning"></i>
                        <i class="fa-solid btn-submit-change-fines fa-circle-check text-success d-none"></i>
                        <i class="fa-solid btn-cancel-change-fines fa-circle-xmark text-danger d-none"></i>
                        </div>
                        </td>
                    </form>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    // searching by department
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.btn-change-fines').click(function(event) {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.btn-submit-change-fines').removeClass('d-none');
                $(this).parents('tr').find('.btn-cancel-change-fines').removeClass('d-none');
                $(this).parents('tr').find('.inp-deduction').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-name').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-time').removeClass('d-none');
                $(this).parents('tr').find('.fines_time').addClass('d-none');
                $(this).parents('tr').find('.fines_name').addClass('d-none');
                $(this).parents('tr').find('.deduction_detail').addClass('d-none');
            });
            $('.btn-cancel-change-fines').click(function(event) {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.btn-submit-change-fines').addClass('d-none');
                $(this).parents('tr').find('.btn-change-fines').removeClass('d-none');
                $(this).parents('tr').find('.inp-deduction').addClass('d-none');
                $(this).parents('tr').find('.inp-fines-name').addClass('d-none');
                $(this).parents('tr').find('.inp-fines-time').addClass('d-none');
                $(this).parents('tr').find('.fines_time').removeClass('d-none');
                $(this).parents('tr').find('.fines_name').removeClass('d-none');
                $(this).parents('tr').find('.deduction_detail').removeClass('d-none');
            });
            $('.btn-submit-change-fines').click(function(event) {
                var this_btn = $(this);
                var id = $(this).parents('tr').find('.inp-fines-id').val();
                var deduction_val = $(this).parents('tr').find('.inp-deduction').val();
                var deduction = deduction_val.replace(/[^0-9\.]+/g, "");
                var name = $(this).parents('tr').find('.inp-fines-name').val();
                var fines = $(this).parents('tr').find('.inp-fines-time').val();
                $.ajax({
                    url: "{{ route('ceo.fines_update') }}",
                    method: "POST",
                    datatype: 'json',
                    data: {
                        id: id,
                        name: name,
                        fines: fines,
                        deduction: deduction,
                    },
                    success: function(response) {
                        console.log('2');
                        this_btn.parents('tr').find('.btn-change-fines').removeClass('d-none');
                        this_btn.addClass('d-none');
                        this_btn.parents('tr').find('.btn-cancel-change-fines').addClass('d-none');
                        this_btn.parents('tr').find('.inp-deduction').addClass('d-none');
                        this_btn.parents('tr').find('.inp-fines-name').addClass('d-none');
                        this_btn.parents('tr').find('.inp-fines-time').addClass('d-none');
                        this_btn.parents('tr').find('.fines_time').text(response[0]["fines_time"]);
                        this_btn.parents('tr').find('.fines_name').text(response[0]["name"]);
                        this_btn.parents('tr').find('.deduction_detail').text(response[0]["deduction_detail"]);
                        this_btn.parents('tr').find('.fines_time').removeClass('d-none');
                        this_btn.parents('tr').find('.fines_name').removeClass('d-none');
                        this_btn.parents('tr').find('.deduction_detail').removeClass('d-none');

                    }
                })
             });
            var currencyInput = document.querySelector('input[data-type="currency"]')
            var currency = 'VND'; // https://www.currency-iso.org/dam/downloads/lists/list_one.xml

            // format inital value
            onBlur({target:currencyInput})
            currencyInput.addEventListener('focus', onFocus)
            currencyInput.addEventListener('blur', onBlur)


            function localStringToNumber( s ){
            return Number(String(s).replace(/[^0-9.-]+/g,""))
            }

            function onFocus(e){
            var value = e.target.value;
            e.target.value = value ? localStringToNumber(value) : ''
            }

            function onBlur(e){
            var value = e.target.value

            var options = {
                maximumFractionDigits : 2,
                currency              : currency,
                style                 : "currency",
                currencyDisplay       : "symbol"
            }
            
            e.target.value = (value || value === 0) 
                ? localStringToNumber(value).toLocaleString(undefined, options)
                : ''
            }
        });
    </script>
@endpush
