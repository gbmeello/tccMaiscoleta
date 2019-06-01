@extends('layouts.app')

@section('styles')
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css' type='text/css' />
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
                    <form id="form-ponto-coleta" class="col-sm-6 col-md-6">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="nome">Nome:</label>
                                <input type="text" class="form-control" name="nome" id="nome">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="telefone1">Latitude:</label>
                                <input type="text" class="form-control" placeholder="Ex: -99.99999999" name="latitude" id="latitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="telefone1">Longitude:</label>
                                <input type="text" class="form-control" placeholder="Ex: -99.99999999" name="longitude" id="longitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="descricao">Descrição:</label>
                                <input type="text" class="form-control" name="descricao" id="descricao">
                            </div>
                        </div>
                    </form>
                    <div id="lista-ponto-coleta" class="col-sm-12 col-md-12">
                        <table id="tbl-ponto-coleta" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <td>Nome</td>
                                    <td>Latitude</td>
                                    <td>Longitude</td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-salvar" class="btn btn-success btn-flat" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.js'></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.min.js'></script>
    <script>

        $(document).ready(function() {

            $("#latitude").inputmask('Regex', {regex: "^([\-0-9]{1,3}).(\\.\\d{1,8})?$"});
            $("#longitude").inputmask('Regex', {regex: "^([\-0-9]{1,3}).(\\.\\d{1,8})?$"});

            initMap();

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let $btnSalvar = $('#btn-salvar');

            let data = $('#form-triagem').serialize();

            $.ajax({
                type: 'POST',
                url: '/api/v1/ponto-coleta/cadastrar',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $btnSalvar.button('loading');
                },
                complete: function() {
                    $btnSalvar.button('reset');
                },
                success: function(data) {

                    if(data.success) {
                        $('#div-resultado').html(HelperJs.showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(HelperJs.showValidationErrors(data.message));
                    }

                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
                    console.error('error');
                }
            });
        }

        function initMap() {

            var tbody = $('#tbl-ponto-coleta').children('tbody');
            var table = tbody.length ? tbody : $('#tbl-ponto-coleta');

            mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
            var map = new mapboxgl.Map({
                container: 'map', // container id
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [-42.025932, -22.972347], // starting position
                zoom: 12 // starting zoom
            });

            map.addControl(new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                zoom: 14,
                placeholder: "Rua, Bairro, Endereço etc...",
                mapboxgl: mapboxgl
            }));

            // Add geolocate control to the map.
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true
            }));

            var arrayPontosColeta = [];

            map.on('click', function (e) {

                if(!$('#nome').val()) {
                    alert('O nome do ponto de coleta precisa ser preenchido');
                    return;
                }

                map.loadImage('/img/recyc_1.png', function(error, image) {

                    if(error) {
                        throw error;
                    }

                    let name = "recyclage-image" + Math.round(Math.random() * 10000000);

                    if (!map.getLayer(name)) {
                        arrayPontosColeta.push({
                            id: name,
                            nome: $('#nome').val(),
                            lng: e.lngLat.lng,
                            lat: e.lngLat.lat
                        });

                        map.addImage(name, image);
                        map.addLayer({
                            "id": name,
                            "type": "symbol",
                            "source": {
                                "type": "geojson",
                                "data": {
                                    "type": "FeatureCollection",
                                    "features": [{
                                        "type": "Feature",
                                        "geometry": {
                                            "type": "Point",
                                            "coordinates": [e.lngLat.lng, e.lngLat.lat]
                                        }
                                    }]
                                }
                            },
                            "layout": {
                                "icon-image": name,
                                "icon-size": 0.15
                            }
                        });

                        table.append(`
                        <tr>
                            <td>${$('#nome').val()}</td>
                            <td>${e.lngLat.lat}</td>
                            <td>${e.lngLat.lng}</td>
                        </tr>`);

                        $("#latitude").val(e.lngLat.lat);
                        $("#longitude").val(e.lngLat.lng);
                    } else {
                        alert('Ops! Aconteceu um erro. Por favor, tente novamente.');
                    }

                });

                // $.each(arrayPontosColeta, function(index, value) {
                //     table.append(`
                //         <tr>
                //             <td>value.id</td>
                //             <td>value.lat</td>
                //             <td>value.lng</td>
                //         </tr>`);
                // });

            });
        }



    </script>

@endsection