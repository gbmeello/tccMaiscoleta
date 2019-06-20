@extends('layouts.app')

@section('styles')
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.css' type='text/css'/>
    <style>
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
        
        .marker {
            background: url('/img/truck-mark.png') no-repeat;
            background-size: 100%;
            width: 50px;
            height: 50px;
            cursor: pointer;
        }
    </style>
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
                    <div id="form-ponto-coleta" class="col-sm-6 col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="nome">Rota:</label>
                                @if(!$rotas->isEmpty())
                                    <select id="slt_rota" class="form-control" name="slt_rota">
                                        <option value="">Selecione a rota...</option>
                                        @foreach ($rotas as $rota)
                                            <option value="{{$rota->pk_rota}}">{{$rota->nome}}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <a href="{{url('rota/cadastrar')}}">Cadastrar nova rota</a>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="nome">Nome:</label>
                                <input type="text" class="form-control" name="nome" id="nome">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="telefone1">Latitude:</label>
                                <input type="text" class="form-control" placeholder="Ex: -22.968460714600695" readonly name="latitude" id="latitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="telefone1">Longitude:</label>
                                <input type="text" class="form-control" placeholder="Ex: -22.968460714600695" readonly name="longitude" id="longitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="descricao">Descrição:</label>
                                <input type="text" class="form-control" name="descricao" id="descricao">
                            </div>
                        </div>
                    </div>
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
    <script>
    
        $(document).ready(function() {

            initMap();

        });

        var arrayPontosColeta = [];

        function initMap() {

            mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-42.025932, -22.972347], // starting position
                zoom: 12 // starting zoom
            });


            var draw = new MapboxDraw({
                // drawing: true,
                displayControlsDefault: false,
                controls: {
                    // polygon: true,
                    trash: true
                }
            });

            mapBoxHelper = new MapBoxHelper(mapboxgl, map, draw);

            map.addControl(new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                zoom: 14,
                placeholder: "Rua, Bairro, Endereço etc...",
                mapboxgl: mapboxgl
            }));

            map.addControl(draw);

            // let mapboxCtrlGroup = $('.mapboxgl-ctrl-group');
            // mapboxCtrlGroup.find('.mapbox-gl-draw_line').attr('title', 'Desenhe a rota desejada');
            // mapboxCtrlGroup.find('.mapbox-gl-draw_trash').attr('title', 'Remova a rota desejada');

            // Add geolocate control to the map.
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            }));


            var popup = new mapboxgl.Popup({
                closeButton: true,
                closeOnClick: true
            });
            
            
            let coords = [];

            let features = [];
            
            map.on('load', function () {                
                // map.addSource("markers", { type: "geojson", data: "" });
                map.addLayer({
                    "id": "ponto_coleta_id",
                    "type": "symbol",
                    "source": {
                        "type": "geojson",
                        "data": {
                            "type": "FeatureCollection",
                            "features": [],
                        }
                    },
                });
            });            

                
            let rotaNome = $('#slt_rota option:selected').text();
            let rotaId = $('#slt_rota').val();
            let pontoColetaNome = $('#nome').val();
            let pontoColetaDescricao = $('#descricao').val();


            map.on('click', function (e) {

                debugger;
                console.log(draw.getSelected());

                var features = map.queryRenderedFeatures(e.point, { layers: ['ponto_coleta_id'] });
                // console.log(features);
                if (features.length) {
                    return;
                }

                let source = map.getSource('ponto_coleta_id');

                var el = document.createElement('div');
                el.className = 'marker';

                let marker = {
                    type: 'Feature',
                    geometry: {
                        type: 'Point',
                        coordinates: [e.lngLat.lng, e.lngLat.lat]
                    },
                    properties: {
                        title: pontoColetaNome,
                        description: pontoColetaDescricao
                    }
                }

                coords.push(marker.geometry.coordinates);

                features.push(marker);

                // console.log(features);

                new mapboxgl.Marker(el)
                    .setLngLat(marker.geometry.coordinates)
                    .setPopup(
                        new mapboxgl.Popup({ offset: 25 }) // add popups
                            .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>')
                    )
                    .addTo(map);                   
                    
                    

                source.setData(features);

                // console.log(source);

            });

            
            function removePoint() {
                debugger;
                if (map.getSource('ponto_coleta_id')) {
                    // map.removeLayer('point');
                    // map.removeSource('point');
                    // $('#calculated-line').empty();
                    // mapBoxHelper.coordinatePontosColeta = [];
                } else {
                    return;
                }
            }


        }
    
    </script>
@endsection