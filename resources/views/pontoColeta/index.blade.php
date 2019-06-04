@extends('layouts.app')

@section('styles')
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl.css' rel='stylesheet' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.3.0/mapbox-gl-geocoder.css' type='text/css' />
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.0.0/mapbox-gl-draw.css' type='text/css'/>
@endsection

@section('contentHeader')
    <h1>
        Ponto de Coleta
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{asset('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ponto de Coleta</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Listas de Ponto de Coleta</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/ponto-coleta/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                        <i class="fa fa-map-marker"></i> Cadastrar Ponto de Coleta
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-ponto-coleta-listar" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nome
                                </th>
                                <th>
                                    Latitude
                                </th>
                                <th>
                                    Longitude
                                </th>
                                <th>
                                    Descrição
                                </th>
                                <th>
                                    Ativo
                                </th>
                                <th>A&ccedil;&atilde;o</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
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

        let $table = $('#table-ponto-coleta-listar');
        let dt = $table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('api/v1/ponto-coleta/listar') }}",

            "columns": [
                {
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
                { "data": "pk_ponto_coleta" },
                { "data": "nome" },
                { "data": "latitude" },
                { "data": "longitude" },
                { "data": "descricao" },
                { "data": "ativo", render: function(data, type, row) {
                        let html = '';
                        if(data == true) {
                            html = '<small class="label pull-right bg-green">Sim</small>';
                        }

                        return html;
                    }},
                { "data": null , width: "100px", render: function(data, type, row) {
                        let html = '';
                        html += `
                            <div class="btn-group" role="group" aria-label="...">
                                <a href="{{ url('rota/editar/') }}/${data.pk_ponto_coleta}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                <button onclick="initializeDeleteDialog('rota/deletar', ${data.pk_ponto_coleta})" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>
                            </div>`;
                        return html;
                    },
                    "targets": -1,
                },
            ],
            "language": configDatatable.language,

            //"order": [[1, 'asc']],
        });

        configDatatable.addShowDetails($table, dt, function(d) {
            let table =
                `<div class="form-group" style="text-align: center; width: 100%">
                    <button onclick="initializeMapModal(${d.latitude}, ${d.longitude})" class="btn btn-app btn-lg"> <i class="fa fa-map"></i> Ver Mapa </button>
                </div>`;

            return table;
        });

    </script>

@endsection