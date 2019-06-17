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

        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/select2/dist/css/select2.min.css') }}">

        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}">

        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fontawesome-5.9.0/css/all.min.css') }}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/Ionicons/css/ionicons.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/chart.js/dist/Chart.min.css') }}">
        <!-- jvectormap -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/jvectormap/jquery-jvectormap.css') }}">
        <!-- Pace -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/PACE/themes/blue/pace-theme-minimal.css') }}">
        <!-- Theme style -->
        {{-- <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}"> --}}
        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/skins/_all-skins.min.css') }}">
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @yield('styles')
    </head>

    <body id="body" class="skin-green-light sidebar-mini">

        <div class="wrapper">
            @include('partials.header')
            @include('partials.menuSidebar')

            <div class="content-wrapper">
                <section class="content-header">
                    @yield('contentHeader')
                </section>
                <section class="content">
                    @include('partials.contentResultado')
                    @yield('content')
                </section>
            </div>
            @include('partials.footer')
            @include('partials.menuAside')
        </div>

        <!-- jQuery 3 -->
        <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>

        <script src="{{ asset('AdminLTE/bower_components/inputmask/dist/min/jquery.inputmask.bundle.min.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
        <!-- FastClick -->
        <script src="{{ asset('AdminLTE/bower_components/fastclick/lib/fastclick.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('AdminLTE/dist/js/adminlte.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/dist/js/demo.js') }}"></script>
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
        <script src="{{ asset('AdminLTE/bower_components/chart.js/dist/Chart.min.js') }}"></script>
        <!-- Pace -->
        <script src="{{ asset('AdminLTE/bower_components/PACE/pace.min.js') }}"></script>

        <script src="{{ asset('AdminLTE/bower_components/select2/dist/js/select2.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/bower_components/select2/dist/js/i18n/pt-BR.js') }}"></script>

        <script src="{{ asset('AdminLTE/bower_components/moment/min/moment.min.js') }}"></script>
        <script src="{{ asset('AdminLTE/bower_components/moment/locale/pt-br.js') }}"></script>

        <script src="{{ asset('AdminLTE/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
        {{-- <script src="{{ asset('AdminLTE/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.pt-BR.min.js') }}"></script> --}}

        <script src="{{ asset('AdminLTE/plugins/bootbox-js/bootbox.all.min.js') }}"></script>

        <script src="{{ asset('js/helperJs.js') }}"></script>

        @yield('scripts')
    </body>

</html>


{{--


    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>



--}}