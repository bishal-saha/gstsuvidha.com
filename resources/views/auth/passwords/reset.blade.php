<!DOCTYPE html>
<html class="no-js css-menubar" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">

    <title>Login | {{ config('app.name') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('backend/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/site.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('backend/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/vendor/waves/waves.css') }}">

    <link rel="stylesheet" href="{{ asset('backend/assets/examples/css/pages/login-v3.css') }}">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('backend/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>

    <!--[if lt IE 9]>
    <script src="{{ asset('backend/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="{{ asset('backend/global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('backend/global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('backend/global/vendor/breakpoints/breakpoints.js') }}"></script>
    <script>
        Breakpoints();
    </script>
</head>
<body class="animsition page-login-v3 layout-full">
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<!-- Page -->
<div class="page vertical-align text-center" data-animsition-in="fade-in" data-animsition-out="fade-out">
    <div class="page-content vertical-align-middle">
        <div class="panel">
            <div class="panel-body">
                <div class="brand">
                    <!--img class="brand-img" src="images/logo.png" alt="KINETIC GST SUVIHA" height="120px" width="120px"-->
                    <h1 class="brand-text font-size-24">{{ config('app.name') }}</h1>
                    <h2 class="brand-text font-size-18">Administrator</h2>
                </div>
                <form method="POST" action="{{ route('password.request') }}">
                    @csrf
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus />
                        <label class="floating-label" for="email">Email</label>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required />
                        <label class="floating-label" for="password">Password</label>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group form-material floating" data-plugin="formMaterial">
                        <input id="password-confirm" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" required />
                        <label class="floating-label" for="password-confirm">Password</label>
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-lg mt-40">Reset Password</button>
                </form>
            </div>
        </div>

        <footer class="page-copyright page-copyright-inverse">
            <p>© {{ date('Y') }}. All RIGHT RESERVED.</p>
            <div class="social">
                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                    <i class="icon bd-twitter" aria-hidden="true"></i>
                </a>
                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                    <i class="icon bd-facebook" aria-hidden="true"></i>
                </a>
                <a class="btn btn-icon btn-pure" href="javascript:void(0)">
                    <i class="icon bd-google-plus" aria-hidden="true"></i>
                </a>
            </div>
        </footer>
    </div>
</div>
<!-- End Page -->
<!-- Core  -->
<script src="{{ asset('backend/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
<script src="{{ asset('backend/global/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('backend/global/vendor/popper-js/umd/popper.min.js') }}"></script>
<script src="{{ asset('backend/global/vendor/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('backend/global/vendor/animsition/animsition.js') }}"></script>
<script src="{{ asset('backend/global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('backend/global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
<script src="{{ asset('backend/global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
<script src="{{ asset('backend/global/vendor/ashoverscroll/jquery-asHoverScroll.js') }}"></script>
<script src="{{ asset('backend/global/vendor/waves/waves.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('backend/global/vendor/switchery/switchery.js') }}"></script>
<script src="{{ asset('backend/global/vendor/intro-js/intro.js') }}"></script>
<script src="{{ asset('backend/global/vendor/screenfull/screenfull.js') }}"></script>
<script src="{{ asset('backend/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
<script src="{{ asset('backend/global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<!-- Scripts -->
<script src="{{ asset('backend/global/js/Component.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin.js') }}"></script>
<script src="{{ asset('backend/global/js/Base.js') }}"></script>
<script src="{{ asset('backend/global/js/Config.js') }}"></script>

<script src="{{ asset('backend/assets/js/Section/Menubar.js') }}"></script>
<script src="{{ asset('backend/assets/js/Section/GridMenu.js') }}"></script>
<script src="{{ asset('backend/assets/js/Section/Sidebar.js') }}"></script>
<script src="{{ asset('backend/assets/js/Section/PageAside.js') }}"></script>
<script src="{{ asset('backend/assets/js/Plugin/menu.js') }}"></script>

<script src="{{ asset('backend/global/js/config/colors.js') }}"></script>
<script src="{{ asset('backend/assets/js/config/tour.js') }}"></script>
<!--script>Config.set('assets', '../../assets');</script-->

<!-- Page -->
<script src="{{ asset('backend/assets/js/site.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/asscrollable.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/slidepanel.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/switchery.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/jquery-placeholder.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/material.js') }}"></script>

<script>
    (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
            Site.run();
        });
    })(document, window, jQuery);
</script>
</body>
</html>