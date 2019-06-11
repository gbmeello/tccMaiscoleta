@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Cadastro de Rotas</h3>
            </div>
            <form id="form-rota" role="form" class="box-body">
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="nome">Nome</label>
                        <input type="text" class="form-control" name="nome" id="nome" maxlength="100">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="observacao">Observa&ccedil;&atilde;o</label>
                        <textarea rows="4" id="observacao" name="observacao" class="form-control"
                            maxlength="500"></textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <button id="btn-salvar" class="btn btn-success btn-flat"
                    data-loading-text="<i class='fa fa-save'></i> Salvar <i class='fa fa-spinner fa-spin'></i>">
                    <i class="fa fa-save"></i> Salvar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script>
        $(document).ready(function() {
            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let data = $('#form-rota').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'POST',
                url: '/api/v1/rota/cadastrar',
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
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
                    }

                },
                error: function(xhr) { // if error occured
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
                }
            });
        }

        //TODO terminar o esquema de rota nessa porra
        // function initMap() {
        //     mapboxgl.accessToken = 'pk.eyJ1IjoibWFyY2lvbWVuZGVzIiwiYSI6ImNqc2VtNGtmeTBzNGQzeXRscWxkMThvcXIifQ.83J82VEpsdmfE-xu9W4uUg';
        //     var map = new mapboxgl.Map({
        //         container: 'map', // container id
        //         style: 'mapbox://styles/mapbox/streets-v11',
        //         center: [-42.025932, -22.972347], // starting position
        //         zoom: 12 // starting zoom
        //     });

        //     debugger;

        //     mapBoxHelper = new MapBoxHelper(mapboxgl, map, createMapDraw());
        //     // map.addControl(mapBoxHelper.draw);

        //     // add create, update, or delete actions
        //     map.on('draw.create', updateRoute);
        //     map.on('draw.update', updateRoute);
        //     map.on('draw.delete', removeRoute);

        //     map.addControl(new MapboxGeocoder({
        //         accessToken: mapboxgl.accessToken,
        //         zoom: 14,
        //         placeholder: "Rua, Bairro, Endereço etc...",
        //         mapboxgl: mapboxgl
        //     }));

        //     // map.addControl(mapBoxHelper.draw);

        //     let mapboxCtrlGroup = $('.mapboxgl-ctrl-group');
        //     mapboxCtrlGroup.find('.mapbox-gl-draw_line').attr('title', 'Desenhe a rota desejada');
        //     mapboxCtrlGroup.find('.mapbox-gl-draw_trash').attr('title', 'Remova a rota desejada');

        //     // Add geolocate control to the map.
        //     map.addControl(new mapboxgl.GeolocateControl({
        //         positionOptions: {
        //             enableHighAccuracy: true
        //         },
        //         trackUserLocation: true
        //     }));

        // }

</script>

@endsection