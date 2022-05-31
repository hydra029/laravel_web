<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>{{$title}}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    {{-- css --}}
    <link href="{{ asset('css/icons.min.css' )}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app-modern.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>
    @stack('css')
</head>
<body class="loading" data-layout="detached"
      data-layout-config='{"leftSidebarCondensed":false,"darkMode":false, "showRightSidebarOnStart": true}'>
@include('layout.header')
<div class="container-fluid">
    <div class="wrapper">
        @include('layout.sidebar')
        <div class="content-page">
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">{{$title}}</h4>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layout.footer')
        </div>
    </div>
</div>
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="dripicons-cross noti-icon"></i>
        </a>
        <h5 class="m-0">Settings</h5>
    </div>
    <div class="rightbar-content h-100" data-simplebar>
        <div class="p-3">
            <div class="alert alert-warning" role="alert">
                <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
            </div>
            <h5 class="mt-3">Color Scheme</h5>
            <hr class="mt-1"/>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="light"
                       id="light-mode-check" checked/>
                <label class="custom-control-label" for="light-mode-check">Light Mode</label>
            </div>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="color-scheme-mode" value="dark"
                       id="dark-mode-check"/>
                <label class="custom-control-label" for="dark-mode-check">Dark Mode</label>
            </div>
            <h5 class="mt-4">Left Sidebar</h5>
            <hr class="mt-1"/>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="fixed" id="fixed-check"
                       checked/>
                <label class="custom-control-label" for="fixed-check">Scrollable</label>
            </div>
            <div class="custom-control custom-switch mb-1">
                <input type="radio" class="custom-control-input" name="compact" value="condensed"
                       id="condensed-check"/>
                <label class="custom-control-label" for="condensed-check">Condensed</label>
            </div>
            <button class="btn btn-primary btn-block mt-4" id="resetBtn">Reset to Default</button>
            <a href="https://themes.getbootstrap.com/product/hyper-responsive-admin-dashboard-template/"
               class="btn btn-danger btn-block mt-3" target="_blank"><i class="mdi mdi-basket mr-1"></i> Purchase
                Now</a>
        </div>
    </div>
</div>
<div class="rightbar-overlay"></div>
<script src="{{ asset('js/jquery.min.js' )}}"></script>
<script src="{{ asset('js/vendor.min.js' )}}"></script>
<script src="{{ asset('js/app.min.js' )}}"></script>
@stack('js')
</body>
</html>