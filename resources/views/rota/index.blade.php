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
        Rota
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Rota</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Lista de Rotas</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                            class="fa fa-minus"></i></button>
                </div>
                <div class="clearfix"></div>
                <a href="{{url('/rota/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-route"></i> Cadastrar nova rota
                </a>
            </div>
            <div class="box-body">
                <table id="table-rota" class="table table-bordered table-striped dataTable">
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
                                Observa&ccedil;&atilde;o
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
        let $table = $('#table-rota');
        let dt = $table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/v1/rota/listar') }}",
                "columns": [
                    {
                        "class": "details-control",
                        "orderable": false,
                        "data": null,
                        "defaultContent": ""
                    },
                    { "data": "pk_rota" },
                    { "data": "nome" },
                    { "data": "observacao" },
                    { "data": "ativo", render: function(data, type, row) {
                            let html = '';

                            if(data == true) {
                                html = '<small class="label pull-right bg-green">Ativo</small>';
                            }

                            return html;
                        }},
                    { "data": null , width: "100px", render: function(data, type, row) {
                            @php
                                $html = '';
                                $html .= '\'<div class="btn-group pull-right" role="group" aria-label="...">';

                                $editar = '<a href="'.url('rota/editar').'/\' + data.pk_rota + \'" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>';
                                $deletar = '<button onclick="initializeDeleteDialog(&quot;rota/deletar&quot;, \' + data.pk_rota + \')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>';

                                if( Auth::user()->hasAnyRoles(['Administrador', 'Cadastrador']) ) {
                                    $html .= $editar;
                                }

                                if( Auth::user()->hasAnyRoles(['Administrador']) ) {
                                    $html .= $deletar;
                                }

                                $html .= '</div>\'';
                            @endphp

                                return {!! $html !!};
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
                    <button onclick="showRotaOnMapModal(${d.pk_rota})" class="btn btn-app btn-lg"> <i class="fa fa-map"></i> Ver Mapa </button>
                </div>`;
            return table;
        });
    </script>

@endsection