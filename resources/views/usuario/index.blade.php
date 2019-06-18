@extends('layouts.app')

@section('contentHeader')
    <h1>
        Usuários
        <small>Lista</small>
    </h1>
    <ol class="breadcrumb">
            <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li class="active">Usuários</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Usuários</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{ url('/usuario/cadastrar') }}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-user-plus"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-usuario" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nome
                                </th>
                                <th>
                                    Email
                                </th>
                                <th>
                                    Perfil
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

        let $table = $('#table-usuario');
        let dt = $table.DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('api/v1/usuario/listar') }}",
            "columns": [
                { "data": "pk_usuario" },
                { "data": "nome" },
                { "data": "email" },
                { "data": "perfil" },
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

                            $editar = '<a href="'.url('usuario/editar').'/\' + data.pk_usuario + \'" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>';
                            $deletar = '<button onclick="initializeDeleteDialog(&quot;usuario/deletar&quot;, \' + data.pk_usuario + \')" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</button>';

                            if( Auth::user()->hasAnyRoles(['Administrador']) )
                            {
                                $html .= $editar;
                                $html .= $deletar;
                            }
                            else
                            {
                                $html .= '<span class="label pull-right bg-red">Permissão insuficiente</span>';
                            }

                            $html .= '</div>\'';
                        @endphp

                            return {!! $html !!};
                    },
                    "targets": -1,
                },
            ],
            "language": configDatatable.language,
        });

    </script>

@endsection