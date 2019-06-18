@extends('layouts.app')

@section('styles')
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.css' type='text/css'/>
    <style>
        .marker {
            background: url('/img/truck-mark.png') no-repeat;
            background-size: 100%;
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
    </style>
@endsection

@section('contentHeader')
    <h1>
        Dashboard
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li class="active">Dashboard</li>
    </ol>
@endsection

@section('content')
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Rotas - Dados</h3>
                </div>
                <div class="box-body">
                    <div id='map' style="width: 100%; height: 250px;"></div>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Fardos - Dados</h3>
                </div>
                <div class="box-body">

                    <div class="col-lg-4 col-md-4 col-xs-4">
                        <div id="box-fardo-qtd" class="small-box bg-blue">
                            <div class="inner">
                                <h3 class="small-box-number">0</h3>
                                <span class="small-box-title">Total</span>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                                Mais informações <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-4">
                        <div id="box-fardo-estoque" class="small-box bg-yellow">
                            <div class="inner">
                                <h3 class="small-box-number">0</h3>
                                <span class="small-box-title">Estoque</span>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                                Mais informações <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-xs-4">
                        <div id="box-fardo-vendido" class="small-box bg-green">
                            <div class="inner">
                                <h3 class="small-box-number">0</h3>
                                <span class="small-box-title">Vendido</span>
                            </div>
                            <div class="icon">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <a href="javascript:0;" id="btn-teste" class="small-box-footer small-box-info-button">
                                Mais informações <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-rota-mais-coletada" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Rotas mais coletadas (em kg's)</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-rota-mais-coletada" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart-rota-mais-coletada" data-chart-name="rota_mais_coletada" class="canvas" />
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-6">
            <div id="box-cliente-maiores-compradores" class="box box-solid">
                <div class="box-header with-border">
                    <h4 class="box-title">Maiores compradores (em kg's)</h4>
                    <div class="box-tools pull-right">
                        <button id="btn-abrir-cliente-maiores-compradores" class="btn bg-blue btn-flat btn-sm"><i class="fa fa-external-link"></i> Detalhes...</button>
                    </div>
                </div>
                <div class="box-body">
                    <canvas id="chart-cliente-maiores-compradores" data-chart-name="cliente_maiores_compradores" class="canvas" />
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')

    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.min.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.js'></script>
    <script src='{{ asset('js/mapboxhelper.js' )}}'></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
    
        $(document).ready(function() {

            // let hoje = new Date().toISOString().slice(0, 10);

            initBoxFardoQuantidade();
            initBoxFardoEmEstoque();
            initBoxFardoVendido();

            initPieRotasMaisColetadas();

            initBarMaioresCompradores();

            initRotas();

        });


        function initBoxFardoQuantidade() {

            let $box = $('#box-fardo-qtd');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/quantidade',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       

        function initBoxFardoEmEstoque() {

            let $box = $('#box-fardo-estoque');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/estoque',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       


        function initBoxFardoVendido() {

            let $box = $('#box-fardo-vendido');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/fardo/vendido',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $box.populateSmallbox(response.data);

                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }       

        function initPieRotasMaisColetadas() {

            let $box = $('#box-rota-mais-coletada');
            let $canvas = $('#chart-rota-mais-coletada');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/rota/rotas-mais-coletadas',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $canvas.chartbox({
                        content: response.data,
                        chart: {
                            title: 'Rotas Mais Coletadas',
                            type: 'pie'
                        },
                        tableLabelColumnText: 'Rota',
                        tableValueColumnText: "Kg's"
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }


        function initBarMaioresCompradores() {

            let $box = $('#box-cliente-maiores-compradores');
            let $canvas = $('#chart-cliente-maiores-compradores');
            let name = $canvas.data('chart-name');

            $.ajax({
                type: 'GET',
                dataType: 'JSON',
                url: '/api/v1/cliente-final/maiores-compradores',
                beforeSend: function() {
                    $box.addClass('whirl traditional');
                },
                complete: function() {
                    $box.removeClass('whirl traditional');
                },
                success: function(response) {

                    $canvas.chartbox({
                        content: response.data,
                        chart: {
                            title: 'Maiores compradores',
                            type: 'bar'
                        },
                        tableLabelColumnText: 'Cliente',
                        tableValueColumnText: "Kg's"
                    });
                },
                error: function (response) {
                    console.error(response.responseText);
                }
            });

        }




        function initRotas() {


            var rotaProperties = {};

            $.get(
                '/api/v1/rota/listar/',
                function (response) {

                    // response = JSON.parse(response);

                    if (!response.success) {
                        bootbox.dialog({
                            title: '<strong>Atenção</strong>',
                            message: response.message,
                            confirm: {
                                className: 'btn-primary'
                            }
                        });
                        return;
                    }

                    mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
                    var map = new mapboxgl.Map({
                        container: 'map', // container id
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [-42.025932, -22.972347], // starting position
                        zoom: 12 // starting zoom
                    });

                    mapBoxHelper = new MapBoxHelper(mapboxgl, map);

                    map.addControl(new MapboxGeocoder({
                        accessToken: mapboxgl.accessToken,
                        zoom: 14,
                        placeholder: "Rua, Bairro, Endereço etc...",
                        mapboxgl: mapboxgl
                    }));

                    map.addControl(new mapboxgl.GeolocateControl({
                        positionOptions: {
                            enableHighAccuracy: true
                        },
                        trackUserLocation: true
                    }));


                    var geojson = {
                        type: 'FeatureCollection',
                        features: []
                    };

                    map.on('load', function() {

                        $.each(response.data, function (i1, rota) {

                            let coords = [];

                            $.each(rota.pontosColeta, function(index, value) {

                                let marker = {
                                    type: 'Feature',
                                    geometry: {
                                        type: 'Point',
                                        coordinates: [value.longitude, value.latitude]
                                    },
                                    properties: {
                                        title: value.nome,
                                        description: value.descricao
                                    }
                                };

                                var el = document.createElement('div');
                                el.className = 'marker';

                                new mapboxgl.Marker(el)
                                    .setLngLat(marker.geometry.coordinates)
                                    .setPopup(
                                        new mapboxgl.Popup({ offset: 25 }) // add popups
                                            .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>')
                                    )
                                    .addTo(map);

                                coords.push(marker.geometry.coordinates);

                                geojson.features.push(marker);

                                // rotaProperties = response.data;

                            });

                            // debugger;
                            coords = coords.join(';');
                            calculateRoute(rota, coords);

                        });
                    });

                    $.each(geojson.features, function(index, value) {

                        var el = document.createElement('div');
                        el.className = 'marker';

                        new mapboxgl.Marker(el)
                            .setLngLat(value.geometry.coordinates)
                            .setPopup(
                                new mapboxgl.Popup({ offset: 25 }) // add popups
                                    .setHTML('<h3>' + value.properties.title + '</h3><p>' + value.properties.description + '</p>')
                            )
                            .addTo(map);

                    });

                }
            );

            // make a directions request
            function calculateRoute(rotaProperties, coords) {
                // debugger;
                var url = 'https://api.mapbox.com/directions/v5/mapbox/driving/' + coords +'?geometries=geojson&steps=true&&access_token=' + mapboxgl.accessToken;
                var req = new XMLHttpRequest();
                req.responseType = 'json';
                req.open('GET', url, true);
                req.onload  = function() {
                    var jsonResponse = req.response;
                    var distance = jsonResponse.routes[0].distance * 0.001;
                    var duration = jsonResponse.routes[0].duration / 60;
                    console.log('Distance: ' + distance.toFixed(2) + ' km<br>Duration: ' + duration.toFixed(2) + ' minutes');
                    var coords = jsonResponse.routes[0].geometry;
                    // add the route to the map
                    addRoute(rotaProperties, coords);
                };
                req.send();
            }


        }



    
    </script>

@endsection