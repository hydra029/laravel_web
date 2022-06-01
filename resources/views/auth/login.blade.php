<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- App favicon -->

    <!-- App css -->
    <link href="{{ asset('css/icons.min.css' )}}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('css/app-modern.min.css' )}}" rel="stylesheet" type="text/css" id="light-style"/>

</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>
<div class="auth-fluid" style="background-image: url('{{asset('img/bg-auth.jpg')}}')">
    <!--Auth fluid left content -->
    <div class="auth-fluid-form-box">
        <div class="align-items-center d-flex h-100">
            <div class="card-body">
                <!-- Logo -->
                <div class="auth-brand text-center text-lg-left">
                        <span><img src="{{ asset('img/cc6b25538116323e310f02dc72369bd4.jpg') }}" height="20" alt="Logo"></span>
                </div>

                <!-- title-->
                <h4 class="mt-0">Sign In</h4>
                <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                <!-- form -->
                <form action="{{ route('process_login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="emailaddress">Email address</label>
                        <input class="form-control" name="email" type="email" id="email" required=""
                               placeholder="Enter your email">
                    </div>
                    <div class="form-group">
                        <a href="#" class="text-muted float-right"><small>Forgot your password?</small></a>
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" required="" id="password"
                               placeholder="Enter your password">
                    </div>
                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                            <label class="custom-control-label" for="checkbox-signin">Remember me</label>
                        </div>
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block"><i class="mdi mdi-login"></i> Log In
                        </button>
                    </div>
                </form>
                <!-- end form-->
            </div> <!-- end .card-body -->
        </div> <!-- end .align-items-center.d-flex.h-100-->
    </div>
    <!-- end auth-fluid-form-box-->

    <!-- Auth fluid right content -->
    <div class="auth-fluid-right text-center">
        <div class="auth-user-testimonial">
            <h2 class="mb-3">
                Every thing in your hand !
            </h2>
            <p class="lead">
                <i class="mdi mdi-format-quote-open"></i>
                Change The World !
                <i class="mdi mdi-format-quote-close"></i>
            </p>
            <p>
                - Hydra -
            </p>
        </div> <!-- end auth-user-testimonial-->
    </div>
    <!-- end Auth fluid right content -->
</div>
<!-- end auth-fluid-->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
				<?php
				$date = date_format(date_create(), 'Y');
				?>
                2021 - {{$date}} © Hail Hydra - Hydra.com
            </div>
            <div class="col-md-6">
                <div class="text-md-right footer-links d-none d-md-block">
                    <a href="javascript: void(0);">About</a>
                    <a href="javascript: void(0);">Support</a>
                    <a href="javascript: void(0);">Contact Us</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- bundle -->
<script src="{{ asset('js/jquery.min.js' )}}"></script>
<script src="{{ asset('js/vendor.min.js' )}}"></script>
<script src="{{ asset('js/app.min.js' )}}"></script>
</body>
</html>