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
        <li><a href="{{url('ponto-coleta/index')}}"><i class="fa fa-users"></i> Ponto de Coleta</a></li>
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
                        {{-- <div class='info-box'>
                            <p>Desenhe sua rota</p>
                            <div id='calculated-line'></div>
                        </div> --}}
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
                                <input type="text" class="form-control" placeholder="Ex: -99.99999999" readonly name="latitude" id="latitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="telefone1">Longitude:</label>
                                <input type="text" class="form-control" placeholder="Ex: -99.99999999" readonly name="longitude" id="longitude">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="descricao">Descrição:</label>
                                <input type="text" class="form-control" name="descricao" id="descricao">
                            </div>
                        </div>
                        <div id="lista-ponto-coleta" style="max-height: 200px" class="col-sm-12 col-md-12">
                            <table id="tbl-ponto-coleta" style="display:block; max-height: 200px; width:100% !important; overflow-y: auto;" class="table table-bordered table-striped table-responsive">
                                <thead>
                                    <tr>
                                        <td style="width: 10%">Rota</td>
                                        <td style="width: 15%">Nome</td>
                                        <td style="width: 20%">Latitude</td>
                                        <td style="width: 25%">Longitude</td>
                                        <td style="width: 25%">Descrição</td>
                                        <td style="width: 5%">#</td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <span class="bg-info"><i class="fa fa-info-circle"></i> Inserir Ícone: dois cliques</span>
                    <button id="btn-salvar" class="btn btn-success btn-flat pull-right" data-loading-text="<i class='fa fa-save'></i> Salvar <i class='fa fa-spinner fa-spin'></i>"
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
    {{-- <script src='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.js'></script> --}}
    <script src='{{ asset('js/mapboxhelper.js' )}}'></script>
    <script>

        $(document).ready(function() {

            $("#latitude").inputmask('Regex', {regex: "^([\-0-9]{1,3}).(\\.\\d{1,16})?$"});
            $("#longitude").inputmask('Regex', {regex: "^([\-0-9]{1,3}).(\\.\\d{1,16})?$"});

            initMap();

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });

        });

        var arrayPontosColeta = [];

        function cadastrar() {

            let $btnSalvar = $('#btn-salvar');

            // debugger;

            // arrayPontosColeta = JSON.parse(arrayPontosColeta);


            $.ajax({
                type: 'POST',
                url: '/api/v1/ponto-coleta/cadastrar',
                data: {
                    _token: '{{ csrf_token() }}'
                    json: JSON.stringify(arrayPontosColeta)
                },
                dataType: 'json',
                beforeSend: function() {
                    $btnSalvar.button('loading');
                },
                complete: function() {
                    $btnSalvar.button('reset');
                },
                success: function(data) {

                    if(data.success) {
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
                    }
                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
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

            // debugger;

            mapBoxHelper = new MapBoxHelper(mapboxgl, map);

            // add create, update, or delete actions
            // map.on('draw.create', updatePoint);
            // map.on('draw.update', updatePoint);
            // map.on('draw.delete', removePoint);

            map.addControl(new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                zoom: 14,
                placeholder: "Rua, Bairro, Endereço etc...",
                mapboxgl: mapboxgl
            }));

            // map.addControl(mapBoxHelper.draw);

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


            map.on('dblclick', function (e) {

                e.preventDefault();

                let rotaNome = $('#slt_rota option:selected').text();
                let rotaId = $('#slt_rota').val();
                let pontoColetaNome = $('#nome').val();
                let pontoColetaDescricao = $('#descricao').val();

                map.on('mouseenter', pontoColetaNome, function (e) {

                    var coordinates = e.features[0].geometry.coordinates.slice();
                    var description = e.features[0].properties.description;

                    // Ensure that if the map is zoomed out such that multiple
                    // copies of the feature are visible, the popup appears
                    // over the copy being pointed to.
                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                    }


                    // Populate the popup and set its coordinates
                    // based on the feature found.
                    popup.setLngLat(coordinates)
                    .setHTML(description)
                    .addTo(map);
                });

                if(! rotaId) {
                    bootbox.alert({
                        title: '<span><strong>Atenção!</strong></span>',
                        message: "O campo rota está vazio!",
                        ok: {
                            className: 'btn-danger'
                        }
                    });
                    return;
                }

                if(! pontoColetaNome) {
                    bootbox.alert({
                        title: '<span><strong>Atenção!</strong></span>',
                        message: "O campo nome está vazio!",
                        ok: {
                            className: 'btn-danger'
                        }
                    });
                    return;
                }

                map.loadImage('/img/truck-mark.png', function(error, image) {

                    if(error) {
                        throw error;
                    }

                    // let name = "recyclage-image" + Math.round(Math.random() * 10000000);

                    if (! map.getLayer(pontoColetaNome)) {
                        arrayPontosColeta.push({
                            rota: rotaId,
                            nome: pontoColetaNome,
                            longitude: e.lngLat.lng,
                            latitude: e.lngLat.lat,
                            descricao: pontoColetaDescricao
                        });

                        map.addImage(pontoColetaNome, image);
                        map.addLayer({
                            "id": pontoColetaNome,
                            "type": "symbol",
                            "source": {
                                "type": "geojson",
                                "data": {
                                    "type": "FeatureCollection",
                                    "features": [{
                                        "type": "Feature",
                                        "properties": {
                                            "description": "<p><strong>Ponto de Coleta - ["+ pontoColetaNome +"]</strong></p><p>"+ pontoColetaDescricao +"</p>",
                                            "icon": "marker",
                                            "size": 15
                                        },
                                        "geometry": {
                                            "type": "Point",
                                            "coordinates": [e.lngLat.lng, e.lngLat.lat]
                                        }
                                    }]
                                }
                            },
                            "layout": {
                                "icon-image": pontoColetaNome,
                                "icon-size": 0.15
                            }
                        });

                        table.append(`
                            <tr>
                                <td style="width: 10%">${rotaNome}</td>
                                <td style="width: 15%">${pontoColetaNome}</td>
                                <td style="width: 20%">${e.lngLat.lat}</td>
                                <td style="width: 25%">${e.lngLat.lng}</td>
                                <td style="width: 25%">${pontoColetaDescricao}</td>
                                <td style="width: 5%">
                                    <button style="width:100%" title="Remover o ponto de coleta ${pontoColetaNome}"
                                        class="btn btn-danger btn-xs btn-flat btn-remove-ponto-coleta">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>`
                        );


                        $('.btn-remove-ponto-coleta').unbind().click(function() {

                            debugger;

                            let $btn = $(this);

                            bootbox.confirm({
                                title: '<strong>Você realmente deseja deletar o ponto de coleta?</strong>',
                                message: "Após confirmação, o ponto de coleta será deletado",
                                buttons: {
                                    confirm: {
                                        className: 'btn-success'
                                    },
                                    cancel: {
                                        className: 'btn-danger'
                                    }
                                },
                                locale: 'br',
                                callback: function (confirm) {
                                    if(confirm) {
                                        if(map.getLayer(pontoColetaNome)) {

                                            console.log($(this).closest('tr'));

                                            $btn.closest('tr').remove();
                                            removePontoColeta(arrayPontosColeta, pontoColetaNome)
                                            map.removeLayer(pontoColetaNome);

                                        }
                                    }
                                }
                            });
                        });


                        $("#latitude").val(e.lngLat.lat);
                        $("#longitude").val(e.lngLat.lng);

                    } else {
                        bootbox.alert({
                            title: '<span><strong>Atenção!</strong></span>',
                            message: "O nome já foi usado!",
                            ok: {
                                className: 'btn-danger'
                            }
                        });
                    }

                });

            });
        }

        function removePontoColeta(array, val) {
            for(var obj in array) {
                if(array[obj].nome == val) {
                    delete array[obj];
                }
            }
        }

    </script>

@endsection