@extends('layouts.app')

@section('contentHeader')
    <h1>
        Coleta
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Coleta</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista das Coletas</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/coleta/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-truck-loading"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-coleta" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Rota
                                </th>
                                <th>
                                    Fornecedor
                                </th>
                                <th>
                                    Data de Coleta
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

        let $table = $('#table-coleta');
        let dt = $table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('api/v1/coleta/listar') }}",
            "columns": [
                {
                    "class": "details-control",
                    "orderable": false,
                    "data": null,
                    "defaultContent": ""
                },
                { "data": "pk_coleta" },
                { "data": "rota_nome" },
                { "data": "fornecedor" },
                { "data": "data_coleta" },
                { "data": "ativo", render: function(data, type, row) {
                        let html = '';
                        if(data == true) {
                            html = '<small class="label pull-right bg-green">Ativo</small>';
                        }
                        return html;
                    }},
                { "data": null , width: "100px", render: function(data, type, row) {
                        let html = '';
                        html += `
                                <div class="btn-group" role="group" aria-label="...">
                                    <a href="{{url('coleta/editar')}}/${data.pk_coleta}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                    <button onclick="initializeDeleteDialog('coleta/deletar', ${data.pk_coleta})" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>
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
            debugger;
                let table =
                    `<div class="form-group">
                        <div class="col-sm-6 col-md-6">
                            <span>Coleta - Observação: </span>
                            <span>${d.observacao}</span>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <span>Veículo: </span>
                            <span>${d.veiculo_modelo}/${d.veiculo_placa}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12">
                            <span>Rota - Observação: </span>
                            <span>${d.rota_observacao}</span>
                        </div>
                    </div>`;

                return table;
            });

    </script>

@endsection