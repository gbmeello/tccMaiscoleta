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
    {{-- <link rel="stylesheet" href="{{ asset('AdminLTE/dist/css/AdminLTE.min.css') }}"> --}}
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
                <button id="btn-login" name="btn-login">
                    <i class="fa fa-sign-in-alt"></i>
                    Login
                </button>

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

    <script>

        $(document).ready(function() {

            $('#btn-login').unbind('click').click(function() {
                authenticate();
            });

        });

        function authenticate() {

            let data = $('#form-login').serialize();
            let $btnLogin = $('#btn-login');

            $.ajax({
                type: 'POST',
                url: '/auth/login',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $btnLogin.button('loading');
                },
                complete: function() {
                    $btnLogin.button('reset');
                },
                success: function(data) {
                    if(data.success) {
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
                    }

                },
                error: function(xhr, response) { // if error occured
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
                }
            });
        }

    </script>
</body>

</html>