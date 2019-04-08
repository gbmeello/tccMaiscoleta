@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Lista de Tipo de res&iacute;duos</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <div class="clearfix"></div>
                    <a href="{{url('/tipo-residuo/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                    <i class="fa fa-user-plus"></i> Cadastrar novo
                    </a>
                </div>
                <div class="box-body">
                    <table id="table-tipo-residuo-listar" class="table table-bordered table-striped dataTable">
                        <thead>
                            <tr>
                                <th>
                                    Id
                                </th>
                                <th>
                                    Nome
                                </th>
                                <th>
                                    Descri&ccedil;&atilde;o
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

    <script src="{{asset('/js/helper.js')}}"></script>
    <script>

        $('#table-tipo-residuo-listar').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ url('api/tipo-residuo/listar') }}",
            "columns": [
                { "data": "id" },
                { "data": "nome" },
                { "data": "descricao" },
                { "data": "status" , render: function(data, type, row) {
                    let html = '';

                    switch (data) {
                        case 1: html = '<small class="label pull-right bg-green">Ativo</small>';
                            break;
                        case 2: html = '<small class="label pull-right bg-red">Inativo</small>';
                            break;
                    }

                    return html;
                }},
                { "data": null , render: function(data, type, row) {
                        let html = 'weqewqewqewqeqwe';
                        return html;
                    },
                    "targets": -1,
                },
            ],
            "columnDefs": [ {
                "targets": -1,
                "data": null,
                "defaultContent": "<button>Click!</button>"
            } ],
            "language": configDatatable.language,
            //"order": [[1, 'asc']],
        });

    </script>

@endsection