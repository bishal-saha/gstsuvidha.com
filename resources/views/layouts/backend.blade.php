<!DOCTYPE html>
<html class="no-js css-menubar" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="bootstrap material admin template">
    <meta name="author" content="">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name') }}</title>

    <link rel="apple-touch-icon" href="{{ asset('backend/assets/images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('backend/global/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/css/bootstrap-extend.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/site.min.css') }}">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/animsition/animsition.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/asscrollable/asScrollable.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/switchery/switchery.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/intro-js/introjs.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/slidepanel/slidePanel.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/flag-icon-css/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/waves/waves.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/examples/css/advanced/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/examples/css/uikit/icon.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/vendor/datatables.net-responsive-bs4/dataTables.responsive.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/examples/css/tables/datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/assets/examples/css/uikit/modals.css') }}">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="{{ asset('backend/global/fonts/material-design/material-design.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/global/fonts/brand-icons/brand-icons.min.css') }}">
    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic'>
    <script defer src="{{ asset('fontawesome/fontawesome-all.min.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="{{ asset('backend/global/vendor/html5shiv/html5shiv.min.js') }}"></script>
    <![endif]-->

    <!--[if lt IE 10]>
    <script src="{{ asset('backend/global/vendor/media-match/media.match.min.js') }}"></script>
    <script src="{{ asset('backend/global/vendor/respond/respond.min.js') }}"></script>
    <![endif]-->

    <!-- Scripts -->
    <script src="{{ asset('backend/global/vendor/breakpoints/breakpoints.js') }}"></script>

    <!-- custom style -->
    <link rel="stylesheet" href="{{ asset('backend/custom/css/mystyle.css') }}">
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        Breakpoints();
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

    </script>
    @yield('extra-header')
</head>
<body class="animsition">
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
@include('includes.header')
<div id="app"></div>
<!-- Page -->
@yield('page')
<!-- End Page -->
<!-- Footer -->
@include('includes.footer')

<!-- Core  -->
<script src="{{ asset('backend/global/vendor/babel-external-helpers/babel-external-helpers.js') }}"></script>
<script src="{{ asset('backend/global/vendor/jquery/jquery.js') }}"></script>
<script src="{{ asset('backend/global/vendor/popper-js/umd/popper.min.js') }}"></script>
<script src="{{ asset('backend/global/vendor/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('backend/global/vendor/animsition/animsition.js') }}"></script>
<script src="{{ asset('backend/global/vendor/mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('backend/global/vendor/asscrollbar/jquery-asScrollbar.js') }}"></script>
<script src="{{ asset('backend/global/vendor/asscrollable/jquery-asScrollable.js') }}"></script>
<script src="{{ asset('backend/global/vendor/waves/waves.js') }}"></script>

<!-- Plugins -->
<script src="{{ asset('backend/global/vendor/switchery/switchery.js') }}"></script>
<script src="{{ asset('backend/global/vendor/intro-js/intro.js') }}"></script>
<script src="{{ asset('backend/global/vendor/screenfull/screenfull.js') }}"></script>
<script src="{{ asset('backend/global/vendor/slidepanel/jquery-slidePanel.js') }}"></script>
<script src="{{ asset('backend/global/vendor/toastr/toastr.js') }}"></script>
<script src="{{ asset('backend/global/vendor/jquery-placeholder/jquery.placeholder.js') }}"></script>

<!-- Scripts -->
<script src="{{ asset('backend/global/js/Component.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin.js') }}"></script>
<script src="{{ asset('backend/global/js/Base.js') }}"></script>
<script src="{{ asset('backend/global/js/Config.js') }}"></script>

<script src="{{ asset('backend/assets/js/Section/Menubar.js') }}"></script>
<script src="{{ asset('backend/assets/js/Section/Sidebar.js') }}"></script>
<script src="{{ asset('backend/assets/js/Section/PageAside.js') }}"></script>
<script src="{{ asset('backend/assets/js/Plugin/menu.js') }}"></script>

<!-- Config -->
<script src="{{ asset('backend/global/js/config/colors.js') }}"></script>
<script src="{{ asset('backend/assets/js/config/tour.js') }}"></script>
<!--script>Config.set('assets', '../../assets');</script-->

<!-- Page -->
<script src="{{ asset('backend/assets/js/Site.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/asscrollable.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/slidepanel.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/switchery.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/toastr.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/jquery-placeholder.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/material.js') }}"></script>
<script src="{{ asset('backend/global/js/Plugin/input-group-file.js') }}"></script>


<script>
    (function(document, window, $){
        'use strict';

        var Site = window.Site;
        $(document).ready(function(){
            Site.run();
        });
    })(document, window, jQuery);
</script>
<script>
    @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type)
        {
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;
            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;
            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;
            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
    @endif
</script>
@yield('extra-footer')
</body>
</html>
