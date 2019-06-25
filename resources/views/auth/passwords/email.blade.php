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
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">
                    {{ __('Enviar email de recuparação', [], app()->getLocale()) }}
                </button>
            </form>

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
