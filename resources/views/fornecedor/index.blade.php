@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Fornecedores</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/fornecedor/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-user-plus"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-fornecedor" class="table table-bordered table-striped dataTable table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nome Fantasia
                                </th>
                                <th>
                                    Razão Social
                                </th>
                                <th>
                                    Estado
                                </th>
                                <th>
                                    Município
                                </th>
                                <th>
                                    Status
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

            let $table = $('#table-fornecedor');
            let dt = $table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/v1/fornecedor/listar') }}",
                "columns": [
                    {
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { "data": "pk_fornecedor" },
                    { "data": "nome_fantasia" },
                    { "data": "razao_social" },
                    { "data": "estado" },
                    { "data": "municipio" },
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
                                    <a href="{{url('fornecedor/editar/')}}${data.pk_fornecedor}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                    <button onclick="HelperJs.initializeDeleteDialog('fornecedor/deletar', ${data.pk_fornecedor})" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>
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
                        <div class="col-sm-4 col-md-4">
                            <span>Email: </span>
                            <span>${d.email}</span>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <span>Telefone 1: </span>
                            <span>${d.telefone1}</span>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <span>Telefone 2: </span>
                            <span>${d.telefone2}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6 col-md-6">
                            <span>Cep: </span>
                            <span>${d.cep}</span>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <span>Bairro: </span>
                            <span>${d.bairro}</span>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <span>Rua: </span>
                            <span>${d.rua}</span>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <span>Logradouro: </span>
                            <span>${d.logradouro}</span>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <span>Rua: </span>
                            <span>${d.complemento}</span>
                        </div>
                    </div>`;

                return table;
            });

        });

    </script>

@endsection