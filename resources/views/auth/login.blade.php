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
    <link rel="stylesheet" href="{{ asset('AdminLTE/bower_components/fontawesome-5.9.0/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">

</head>

<body class="hold-transition background-coleta">

    <div class="login-page">
        <div class="form">
            <fieldset>
                <legend>Bem vindo ao Sistema - +Coleta</legend>
                <form id="form-login">
                    @csrf
                    <input type="text" name="email" placeholder="Email" />
                    <input type="password" name="senha" placeholder="Senha" />
                </form>
                <button id="btn-login" name="btn-login" data-loading-text="<i class='fa fa-sign-in-alt'></i> Login <i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-sign-in-alt"></i>
                    Login
                </button>

                <br>
                <div id="clearfix"></div>
                <br>

                <a href="{{url('password/reset')}}">Esqueceu a senha?</a>

                <br>
                <div id="clearfix"></div>
                <br>

                <div id="div-resultado"></div>
            </fieldset>
        </div>
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('AdminLTE/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/helperJs.js') }}"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>