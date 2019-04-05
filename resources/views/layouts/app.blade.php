<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', '+coleta') }}</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/datatables.net/css/dataTables.bootstrap.min.css') }}">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/font-awesome/css/font-awesome.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/jvectormap/jquery-jvectormap.css') }}">
        <!-- Pace -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/PACE/themes/blue/pace-theme-minimal.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}">
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/app.css') }}">
        @yield('styles')
    </head>

    <body id="body" class="skin-green-light sidebar-mini">

        <div class="wrapper">
            @include('partials.header')
            @include('partials.menuSidebar')

            <div class="content-wrapper">
                @include('partials.contentHeader')
                <section class="content">
                    @yield('content')
                </section>
            </div>

            @include('partials.footer')
        </div>

        <!-- jQuery 3 -->
        <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
        <!-- Sparkline -->
        <script src="{{ asset('AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/bower_components/datatables.net/js/jquery.dataTables.js') }}"></script>
        <script src="{{ asset('AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script>
        <!-- jvectormap -->
        <script src="{{ asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
        <!-- Slimscroll -->
        <script src="{{ asset('AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <!-- ChartJS -->
        <script src="{{ asset('AdminLTE/bower_components/chart.js/Chart.js') }}"></script>
        <!-- Pace -->
        <script src="{{ asset('AdminLTE/bower_components/PACE/pace.min.js') }}"></script>
        @yield('scripts')
    </body>

</html>