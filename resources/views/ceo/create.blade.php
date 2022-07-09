@extends('layout.master')
@include('ceo.menu')

@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/af-2.3.7/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style type="text/css">
        .div-form-create table tr td {
            border: 0;
        }
        /* @property --rotate {
            syntax: "<angle>";
            initial-value: 132deg;
            inherits: false;
            } */
        :root {
            --card-height: 65vh;
            --card-width: calc(var(--card-height) / 1.5);
            }
        .choose-card {
            width: var(--card-width);
            height: var(--card-height);
            padding: 3px;
            margin: 3%;
            position: relative;
            border-radius: 6px;
            justify-content: center;
            align-items: center;
            text-align: center;
            display: flex;
            font-size: 1.5em;
            cursor: pointer;
            font-family: cursive;
            }



        .image-upload>input {
            display: none;
        }

        .profile-card-img {
            width: 30%;
            height: 100%;
        }

        .profile-card-info {
            width: 70%;
            height: 100%;
        }

        .profile-card-info-basic {
            height: 75%;
        }

        .profile-card-roles {
            height: 25%;
        }
    </style>
@endpush
@section('content')
    <div class="choose-card-add d-flex p-2">
        <div class="choose-card float-left" style="background-color: rgb(88 199 250 / 100%)" data-id="1">
             <i class="fa-solid fa-circle-plus"></i>
            <span> Add employee</span>
        </div>
        <div class="choose-card float-left" style="background-color: rgb(188 109 250 / 100%)" data-id="2">
             <i class="fa-solid fa-circle-plus"></i>
            <span>  Add accoutant </span>
        </div>
        <div class="choose-card float-left" style="background-color: rgb(188 199 100 / 100%)" data-id="3">
             <i class="fa-solid fa-circle-plus"></i>
            <span>  Add manager</span>
        </div>
    </div>

    {{-- form add --}}
    <div class="div-form-create d-none ">
        <button class="btn-warning btn-back rounded-pill " type="button">
            <span class="btn-label">
                <i class="fa-solid fa-circle-arrow-left"></i>
            </span>
            back
        </button>
        <br>
        <form action="" id="form-create" method="post">
            @csrf
            <div class="profile-card col-12">
                <div class="profile-card-img float-left ">
                    <div class="image-upload">
                        <label for="file-input" class="text-center">
                            <img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                            <span>Click here to chage avatar</span>
                        </label>

                        <input id="file-input" type="file" />
                    </div>
                </div>
                <div class="profile-card-info float-left">
                    <div class="profile-card-info-basic">
                        <table class="table">
                            <tr>
                                <td class="col-6">
                                    <input type="text" name="fname" class="form-control" placeholder="First Name">
                                </td>
                                <td>
                                    <input type="text" name="lname" class="form-control" placeholder="Last Name">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" align="center">
                                    <input type="radio" name="gender" value="1"> Male
                                    <span> / </span>
                                    <input type="radio" name="gender" value="0"> Female
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"> <input type="date" name="date" id="date" class="form-control"
                                        style="width: 100%; display: inline;" required value=""
                                        placeholder="Date of birth"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Address: </td>
                                <td>
                                    <input type="text" name="address" value="" placeholder="Address"
                                        class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="number" name="number_phone" value="" placeholder="Number phone"
                                        class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="email" name="email" value="" placeholder="Email"
                                        class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="password" value="" placeholder="Password"
                                        class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>department</span>
                                    <select name="dept_id">

                                    </select>
                                </td>
                                <td>
                                    <span>role</span>
                                    <select name="role_id">

                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-success">Submit</button>
                                </td>
                            </tr>
                        </table>
                    </div>


                </div>
            </div>
        </form>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript">
        $(document).ready( function() {
            $('.choose-card').click( function() {
                var choose = $(this).data('id');
                console.log(choose);
                $('.choose-card').addClass('d-none');
                $('.div-form-create').removeClass('d-none');


                create(choose);
            });

            $('.btn-back').click(function() {
                $('.title-name').text('');
                $('.choose-card').removeClass('d-none');
                $('.div-form-create').addClass('d-none');
            });

            function create(choose){
                $.ajax({
                    url: if (choose == 1 ){
                        '{{ route('employees.store') }}',
                    }elseif (choose == 2) {
                        '{{ route('accountants.store') }}',
                    }else{
                        '{{ route('managers.store') }}',
                    }

                })
            }
        });
    </script>
@endpush
