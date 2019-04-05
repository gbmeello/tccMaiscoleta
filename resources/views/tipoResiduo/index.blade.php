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
                    <table id="table-tipo-residuo-listar" class="table table-bordered table-striped dataTable display">
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
                                Descri&ccedil;&atilde;o
                            </th>
                            <th>
                                Status
                            </th>
                            <th>A&ccedil;&atilde;o</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th></th>
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
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        $('#table-tipo-residuo-listar').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                "url": "{{ url('api/tipo-residuo/listar') }}",
                "dataType": "json",
                "type": "POST",
                "data":{ _token: "{{ csrf_token() }}"}
            },
            "columns": [
                { "data": "pk_tipo_residuo" },
                { "data": "nome" },
                { "data": "descricao" },
                { "data": "status" },
                {
                    "class":          "details-control",
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ""
                },
            ],
            "order": [[1, 'asc']]
        });

    </script>

@endsection