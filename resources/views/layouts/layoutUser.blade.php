<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ asset('') }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="asset/img/apple-icon.png">
    <link rel="icon" type="image/png" href="asset/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />

    <!-- CSS Files -->
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/material-kit.css?v=1.2.1" rel="stylesheet" />
    <link href="css/user-app.css" rel="stylesheet" />
</head>

<body class="profile-page">
    <nav class="navbar navbar-primary navbar-transparent navbar-fixed-top navbar-color-on-scroll">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="../presentation.html">SohaApp</a>
            </div>

            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="{{ route('user.dashboard') }}">
                            <i class="material-icons">apps</i> Tài khoản
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user.payment') }}" target="_blank">
                            <i class="material-icons">shopping_cart</i> Nạp Coin
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="material-icons">people</i>
                            @if (Auth::user())
                                {{ Auth::user()->name }}
                            @endif
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu dropdown-with-icons">
                            <li>
                                <a href="/logout">
                                    Sign Out
                                </a>

                            </li>

                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </nav>


    <div class="page-header header-filter" data-parallax="true"
        style="background-image: url('../img/examples/city.jpg');"></div>
    {{-- content space --}}
    @yield('content')
    {{-- end content space --}}



    <footer class="footer">
        <div class="container">
            <nav class="pull-left">
                <ul>
                    <li>
                        <a href="#">
                            SohaApp
                        </a>
                    </li>
                </ul>
            </nav>
            <div class="copyright pull-right">
                &copy;
                <script>
                    document.write(new Date().getFullYear())
                </script>, made with <i class="fa fa-heart heart"></i> by SohaApp
            </div>
        </div>
    </footer>


</body>
<!--   Core JS Files   -->
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/material.min.js"></script>

<!--    Plugin for Date Time Picker and Full Calendar Plugin   -->
<script src="js/moment.min.js"></script>

<!--	Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/   -->
<script src="js/nouislider.min.js" type="text/javascript"></script>

<!--	Plugin for the Datepicker, full documentation here: https://github.com/Eonasdan/bootstrap-datetimepicker   -->
<script src="js/bootstrap-datetimepicker.js" type="text/javascript"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select   -->
<script src="js/bootstrap-selectpicker.js" type="text/javascript"></script>

<!--	Plugin for Tags, full documentation here: http://xoxco.com/projects/code/tagsinput/   -->
<script src="js/bootstrap-tagsinput.js"></script>

<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput   -->
<script src="js/jasny-bootstrap.min.js"></script>

<!--    Plugin For Google Maps   -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

<!--    Control Center for Material Kit: activating the ripples, parallax effects, scripts from the example pages etc    -->
<script src="js/material-kit.js?v=1.2.1" type="text/javascript"></script>

</html>
