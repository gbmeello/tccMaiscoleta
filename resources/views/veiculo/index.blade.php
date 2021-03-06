@extends('layouts.app')

@section('contentHeader')
    <h1>
        Veículo
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Veículo</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Ve&iacute;culos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/veiculo/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-truck"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-veiculo" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Modelo
                                </th>
                                <th>
                                    Placa
                                </th>
                                <th>
                                    Tipo
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

    <script>

        $(document).ready(function () {

            let $table = $('#table-veiculo');
            let dt = $table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/v1/veiculo/listar') }}",
                "columns": [
                    {
                        "class": "details-control",
                        "orderable": false,
                        "data": null,
                        "defaultContent": ""
                    },
                    { "data": "pk_veiculo" },
                    { "data": "modelo" },
                    { "data": "placa" },
                    { "data": "tipo" },
                    { "data": "ativo", render: function(data, type, row) {
                        let html = '';

                        if(data == true) {
                            html = '<small class="label pull-right bg-green">Sim</small>';
                        }

                        return html;
                    }},
                    { "data": null , width: "100px", render: function(data, type, row) {
                            @php
                                $html = '';
                                $html .= '\'<div style="text-align:right;" class="btn-group pull-right" role="group" aria-label="...">';

                                $editar = '<a href="'.url('veiculo/editar').'/\' + data.pk_veiculo + \'" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>';
                                $deletar = '<button onclick="initializeDeleteDialog(&quot;veiculo/deletar&quot;, \' + data.pk_veiculo + \')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>';

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
                return `<p><strong>${d.observacao}</strong></p>`;
            });

        });

    </script>

@endsection