@extends('layout.master')
@include('ceo.menu')
@section('content')
    @push('css')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .div-change-page {
                width: 200px;
                top: -40px
            }

            .div-change-page .change-page {
                background-color: rgb(234, 226, 226);
                width: 100px;
                margin-bottom: 10px;
                border: 1px rgb(242, 199, 199) solid;
                cursor: pointer;
            }

            .div-change-page .change-page span {
                line-height: 30px
            }

            .btn-add-pay-rate,
            .btn-add-fines {
                margin-left: 48%;
                margin-top: 10px;
            }
        </style>
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
        <div class="col-12 p-2 border border-1 border-light bg-dark text-white ">
            <div >
                <h4 class="tittle-pay-rate ">Fines</h4>
            </div>
        </div>
        <div class="col-12 p-2 border border-1 border-light fines-details">
            <table class="table table-striped table-bordered">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>Fines</th>
                    <th>Deduction</th>
                    <th>Action</th>
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
                        <div class="">
                        <button type="button" class="btn btn-change-fines btn-primary">Change</button>
                        <button type="button" class="btn btn-submit-change-fines btn-primary d-none">Save</button>
                        </div>
                        </td>
                    </form>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="div-inp-add-fines d-none">
            <form action="{{ route('ceo.fines_store') }}" method="post">
                @csrf
                <table  class="table">
                   <tr>
                       <td>
                           <span>Name : </span>
                           <input type="text" name="name" class="input-fines-name">
                       </td>
                       <td>
                           <span>Fines : </span>
                           <input type="text" name="fines" class="input-fines">
                       </td>
                       <td>
                           <span>Deduction : </span>
                           <input type="text" name="deduction" class="input-fines-deduction" >
                       </td>
                       <td>
                           <button type="submit" name="" class="btn-save-add-fines btn btn-primary" >save</button>
                       </td>
                   </tr>
                </table>
            </form>
        </div>
        <div class="btn btn-add-fines btn-success "><i class="fa-solid fa-circle-plus"></i> Add</div>
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
            $('.title-name').text(' > Fines');
            $('.btn-change-fines').click(function(event) {
                $(this).addClass('d-none');
                $(this).parents('tr').find('.btn-submit-change-fines').removeClass('d-none');
                $(this).parents('tr').find('.inp-deduction').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-name').removeClass('d-none');
                $(this).parents('tr').find('.inp-fines-time').removeClass('d-none');
                $(this).parents('tr').find('.fines_time').addClass('d-none');
                $(this).parents('tr').find('.fines_name').addClass('d-none');
                $(this).parents('tr').find('.deduction_detail').addClass('d-none');
            });
            $('.btn-submit-change-fines').click(function(event) {
                var this_btn = $(this);
                var id = $(this).parents('tr').find('.inp-fines-id').val();
                var deduction = $(this).parents('tr').find('.inp-deduction').val();
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
            $('.btn-add-fines').click(function(){
                $(this).addClass('d-none');
                $('.div-inp-add-fines').removeClass('d-none');

            })
            $("input[data-type='currency']").on({
                keyup: function() {
                formatCurrency($(this));
                },
            });

            function formatNumber(n) {
                // format number 1000000 to 1,234,567
                return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
                }


                function formatCurrency(input) {
                // appends $ to value, validates decimal side
                // and puts cursor back in right position.

                // get input value
                var input_val = input.val();

                // don't validate empty input
                if (input_val === "") { return; }

                // original length
                var original_len = input_val.length;

                // initial caret position
                var caret_pos = input.prop("selectionStart");

                // check for decimal
                if (input_val.indexOf(".") >= 0) {

                    // get position of first decimal
                    // this prevents multiple decimals from
                    // being entered
                    var decimal_pos = input_val.indexOf(".");

                    // split number by decimal point
                    var left_side = input_val.substring(0, decimal_pos);
                    var right_side = input_val.substring(decimal_pos);

                    // add commas to left side of number
                    left_side = formatNumber(left_side);

                    // validate right side
                    right_side = formatNumber(right_side);

                    // On blur make sure 2 numbers after decimal


                    // Limit decimal to only 2 digits
                    right_side = right_side.substring(0, 2);

                    // join number by .
                    input_val = left_side + "." + right_side + "VND";

                } else {
                    // no decimal entered
                    // add commas to number
                    // remove all non-digits
                    input_val = formatNumber(input_val);
                    input_val = input_val + "VND";

                }

                // send updated string to input
                input.val(input_val);

                // put caret back in the right position
                var updated_len = input_val.length;
                caret_pos = updated_len - original_len + caret_pos;
                input[0].setSelectionRange(caret_pos, caret_pos);
                }

        });
    </script>
@endpush
