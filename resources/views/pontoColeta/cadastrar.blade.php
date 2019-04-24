@extends('layouts.app')

@section('styles')
    <link href='https://api.mapbox.com/mapbox-gl-js/v0.53.0/mapbox-gl.css' rel='stylesheet' />
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Salvar Pontos de Coleta</h3>
                </div>
                <div class="box-body">
                    <div id='map' style='width: 400px; height: 300px;'></div>
                </div>
                <div class="box-footer">
                    <button id="btn-tipo-residuo-salvar" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                    <br>
                    <div id="div-resultado"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script src='https://static-assets.mapbox.com/gl-pricing/dist/mapbox-gl.js'></script>
    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>

        mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
        var map = new mapboxgl.Map({
            container: 'map', // container id
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-42.025932, -22.972347], // starting position
            zoom: 12 // starting zoom
        });

        // Add geolocate control to the map.
        map.addControl(new mapboxgl.GeolocateControl({
            positionOptions: {
                enableHighAccuracy: true
            },
            trackUserLocation: true
        }));

    </script>

@endsection