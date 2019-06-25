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
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="form">
        <fieldset>
            <legend>{{ __('Resetar senha') }}</legend>

            <div class="card-header">{{ __('Verifique seu endereço de email') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('Um novo link de verificação foi enviado para seu email.') }}
                    </div>
                @endif

                {{ __('Antes de prosseguir, por favor, cheque o seu email e seu link de verificação.') }}
                {{ __('Se você ainda não recebeu o email...') }}, <a href="{{ route('verification.resend') }}">{{ __('Clique aqui pare enviar novamente') }}</a>.
            </div>

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

