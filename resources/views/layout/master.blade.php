<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>{{$title}}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="An APP to check attendance and make salary sheet" name="description"/>
	<meta content="Hydra" name="author"/>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	{{-- css --}}
	<link href="{{ asset('css/icons.min.css' )}}" rel="stylesheet" type="text/css"/>
	<link href="{{ asset('css/app.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	<link href="{{ asset('css/app-modern.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
	@stack('css')
	<style>
        ul li {
            list-style-type: none;
        }

        i,
        img {
            cursor: pointer;
        }

        i {
            font-size: 1.2em;
        }

	</style>
</head>
<body class="loading" data-layout="detached"
      data-layout-config='{"leftSidebarCondensed":false,"darkMode":true, "showRightSidebarOnStart": false}'>
@include('layout.header')
<div class="container-fluid m-0" style="max-width: 100%;">
	<div class="wrapper">
		@include('layout.sidebar')
		<div class="content-page">
			<div class="content">
				<div class="row">
					<div class="col-12">
						<div class="page-title-box">
							<span class="page-title font-weight-bold">{{$title}}</span>
							<span class="page-title font-weight-bold title-name"></span>
						</div>
					</div>
				</div>
				<div class="card position-relative">
					<div class="card-body">
						<div class="row">
							@yield('content')
						</div>
					</div>
				</div>
			</div>
			@include('layout.footer')
		</div>
	</div>
</div>
<script src="{{ asset('js/vendor.min.js' )}}"></script>
<script src="{{ asset('js/app.min.js' )}}"></script>
<script src="{{ asset('js/helper.js' )}}"></script>
@include('layout.notify')
<script src="https://kit.fontawesome.com/b0fe355241.js" crossorigin="anonymous"></script>
<script src="{{asset('js/getInfor.js')}}" crossorigin="anonymous"></script>
@stack('js')
</body>
</html>
