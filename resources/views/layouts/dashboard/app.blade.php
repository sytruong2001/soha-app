<!doctype html>
<html lang="en">

<head>
    <base href="{{ asset('') }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="css/dashboard/bootstrap.min.css" rel="stylesheet" />

    <!--  Light Bootstrap Dashboard core CSS    -->
    <link href="css/dashboard/light-bootstrap-dashboard.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="css/dashboard/pe-icon-7-stroke.css">
    <link href="css/dashboard/nestable.css">
    <link href="css/app.css">
    @stack('css')
</head>

<body>

    <div class="wrapper">
        <!-- Menu -->
        @include('layouts.dashboard.menu')
        <div class="main-panel">
            <!-- Header -->
            @include('layouts.dashboard.header')

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('layouts.dashboard.footer')

        </div>
    </div>


</body>
<!--   Core JS Files  -->
<script src="js/dashboard/jquery.min.js" type="text/javascript"></script>
<script src="js/dashboard/bootstrap.min.js" type="text/javascript"></script>
<script src="js/dashboard/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<script src="js/app.js" type="text/javascript"></script>

<!--  Forms Validations Plugin -->
<script src="js/dashboard/jquery.validate.min.js"></script>
<script src="js/dashboard/nouislider.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="js/dashboard/moment.min.js"></script>

<!--  Date Time Picker Plugin is included in this js file -->
<script src="js/dashboard/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<!--  Select Picker Plugin -->
<script src="js/dashboard/bootstrap-selectpicker.js"></script>

<!--  Checkbox, Radio, Switch and Tags Input Plugins -->
<script src="js/dashboard/bootstrap-switch-tags.min.js"></script>

<!--  Charts Plugin -->
<script src="js/dashboard/chartist.min.js"></script>

<!--  Notifications Plugin    -->
<script src="js/dashboard/bootstrap-notify.js"></script>

<!-- Sweet Alert 2 plugin -->
<script src="js/dashboard/sweetalert2.js"></script>


<!-- Vector Map plugin -->
<script src="js/dashboard/jquery-jvectormap.js"></script>

<!-- Wizard Plugin    -->
<script src="js/dashboard/jquery.bootstrap.wizard.min.js"></script>

<!--  Bootstrap Table Plugin    -->
<script src="js/dashboard/bootstrap-table.js"></script>

<!--  Plugin for DataTables.net  -->
<script src="js/dashboard/jquery.datatables.js"></script>


<!--  Full Calendar Plugin    -->
<script src="js/dashboard/fullcalendar.min.js"></script>

<!-- Light Bootstrap Dashboard Core javascript and methods -->
<script src="js/dashboard/light-bootstrap-dashboard.js?v=1.4.1"></script>

<script src="js/dashboard/jquery.nestable.js"></script>

<script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>

@stack('js')

</html>
