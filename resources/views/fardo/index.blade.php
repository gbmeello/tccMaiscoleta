@extends('layouts.app')

@section('contentHeader')
    <h1>
        Fardo
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Fardo</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Fardo</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/fardo/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-cubes"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-fardo" class="table table-bordered table-striped dataTable table-responsive">
                        <thead>
                            <tr>
                                <th></th>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Lote
                                </th>
                                <th>
                                    Data de Venda
                                </th>
                                <th>
                                    Peso
                                </th>
                                <th>
                                    Tipo de Resíduo
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

            let $table = $('#table-fardo');
            let dt = $table.DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/v1/fardo/listar') }}",
                "columns": [
                    {
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { "data": "pk_fardo" },
                    { "data": "lote" },
                    { "data": "data_venda" },
                    { "data": "peso" },
                    { "data": "tr_nome" },
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
                                $html .= '\'<div class="btn-group pull-right" role="group" aria-label="...">';

                                $editar = '<a href="'.url('fardo/editar').'/\' + data.pk_fardo + \'" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>';
                                $deletar = '<button onclick="initializeDeleteDialog(&quot;fardo/deletar&quot;, \' + data.pk_fardo + \')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>';

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
                    `<div class="form-group">
                        <div class="col-sm-12 col-md-12">
                            <span>Observação: </span>
                            <span>${d.observacao}</span>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <span>Vendido para: </span>
                            <span>${d.cf_razao_social}</span>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <span>Data de Triagem: </span>
                            <span>${d.t_data_triagem}</span>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <span>Triagem - Observação: </span>
                            <span>${d.t_observacao}</span>
                        </div>
                    </div>`;

                return table;
            });

        });

    </script>

@endsection