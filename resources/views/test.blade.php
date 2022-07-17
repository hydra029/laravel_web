@extends('layout.master')
@include('employees.menu')
@push('css')
    <link href="{{ asset('css/main.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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
<div class="div-form-create  ">
    <button class="btn-warning btn-back rounded-pill " type="button">
        <span class="btn-label">
            <i class="fa-solid fa-circle-arrow-left"></i>
        </span>
        back
    </button>
    <br>
    <label for="import-csv" class="btn btn-info ">
        Import CSV
    </label>
    <form id="input-avatar" action="" method="post"  enctype = 'multipart/form-data' >

        <div class="profile-card-img float-left ">
            <div class="image-upload">
                <label for="avatar-input" class="text-center">
                    <img src="{{ asset('img/istockphoto-1223671392-612x612.jpg') }}" width="100%">
                    <span>Click here to chage avatar</span>
                </label>
                <input type="file" name="avatar" id="avatar-input">
            </div>
        </div>
        <button type="submit">ok</button>
    </form>

@endsection
@push('js')
    <script src="{{ asset('js/main.min.js' )}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script> $(document).ready(async function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });



        $('#import-csv').change(function(event) {
            var formData = new FormData();
            formData.append('file', $(this)[0].files[0]);
            $.ajax({
                type: "post",
                url: "{{ route('ceo.import_employee') }}",
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                enctype: 'multipart/form-data',
                processData: false,
                dataType: "json",
                success: function (response) {
                    $.toast({
                        heading: "Import CSV Success",
                        text: "Your CSV file has been successfully",
                        showHidetransition:'slide',
                        position: 'button-right',
                        icon: 'success',
                    })
                }

            });
        });

        $('#input-avatar').submit(function (e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
            type:'POST',
            url:  "{{ route('test.input_avatar') }}",
            data: form.serialize(),
            dataType: 'json',
            success:function(response){
                console.log("success");
            },
            error: function(data){
                console.log("error");
                console.log(data);
            }
            });
            });
    });
    </script>
@endpush
