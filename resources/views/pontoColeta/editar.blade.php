@extends('layouts.app')

@section('styles')
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css' type='text/css' />
    {{-- <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.css' type='text/css'/> --}}
    {{-- <style>
        .info-box {
            height: 100px;
            width: 150px;
            position: absolute;
            top: 10px;
            left: 20px;
            background-color: rgba(255, 255, 255, .9);
            padding: 15px;
            text-align: left;
            font-family: 'Arial';
            margin: 0;
            font-size: 13px;
        }
    </style> --}}
@endsection

@section('contentHeader')
    <h1>
        Ponto de Coleta
        <small>Cadastro</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{url('ponto-coleta/index')}}"><i class="fa fa-map-marker-alt"></i> Ponto de Coleta</a></li>
        <li class="active">Cadastro</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastrar Pontos de Coleta</h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-6 col-md-6">                        
                        <div id='map' style="width: 100%; height: 500px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection