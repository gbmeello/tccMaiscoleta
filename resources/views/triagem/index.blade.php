@extends('layouts.app')

@section('contentHeader')
    <h1>
        Triagem
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Triagem</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Triagem</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/triagem/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                        <i class="fa fa-filter"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-triagem" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Data da Triagem
                                </th>
                                <th>
                                    Data da Coleta
                                </th>
                                <th>
                                    Rota
                                </th>
                                <th>
                                    Veículo
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

            let $table = $('#table-triagem');
            let dt = $table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/v1/triagem/listar') }}",
                "columns": [
                    {
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { "data": "pk_triagem" },
                    { "data": "data_triagem" },
                    { "data": "c_data_coleta" },
                    { "data": "r_nome" },
                    { "data": "v_veicuo" },
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
                                        <a href="{{url('triagem/editar')}}/${data.pk_triagem}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                        <button onclick="initializeDeleteDialog('triagem/deletar', ${data.pk_triagem})" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>
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
                    `<div class="form-group">
                        <div class="col-sm-12 col-md-12">
                            <span>Observação: </span>
                            <span>${d.observacao}</span>
                        </div>
                    </div>`;

                return table;
            });

        });

    </script>

@endsection