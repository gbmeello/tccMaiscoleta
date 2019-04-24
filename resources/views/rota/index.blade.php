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
                    <a href="{{url('/rota/cadastrar')}}" class="btn btn-primary btn-sm" style="margin-top: 10px;">
                        <i class="fa fa-user-plus"></i> Cadastrar dsadsa
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
                                    Observa&ccedil;&atilde;o
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
            "ajax": "{{ url('api/v1/rota/listar') }}",
            "columns": [
                { "data": "id" },
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
                        let html = '';
                        html += `
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a href="{{ url('rota/editar/') }}/${row.id}" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
                                        <a href="#" class="btn btn-danger btn-flat btn-xs"><i class="fa fa-trash"></i> Excluir</a>
                                    </div>`;
                        return html;
                    },
                    "targets": -1,
                },
            ],
            "language": configDatatable.language,
            //"order": [[1, 'asc']],
        });

    </script>

@endsection