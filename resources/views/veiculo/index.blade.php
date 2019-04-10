@extends('layouts.app')

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
                    <i class="fa fa-user-plus"></i> Cadastrar novo
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

    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>

        $(document).ready(function () {

            let dt = $('#table-veiculo').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ url('api/veiculo/listar') }}",
                "columns": [
                    {
                        "class":          "details-control",
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ""
                    },
                    { "data": "id" },
                    { "data": "modelo" },
                    { "data": "placa" },
                    { "data": "tipo" },
                    { "data": "observacao" },
                    { "data": "status", render: function(data, type, row) {
                        let html = '';

                        switch (data) {
                            case 1: html = '<small class="label pull-right bg-green">Ativo</small>';
                                break;
                            case 2: html = '<small class="label pull-right bg-red">Inativo</small>';
                                break;
                        }

                        return html;
                    }},
                    { "data": null , width: "100px", render: function(data, type, row) {
                            let html = '';
                            html += `
                                    <div class="btn-group" role="group" aria-label="...">
                                        <a href="#" class="btn btn-primary btn-flat btn-xs"><i class="fa fa-edit"></i> Editar</a>
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

            //configDatatable.addShowDetails(dt);

            // Array to track the ids of the details displayed rows
            var detailRows = [];

            $('#table-veiculo tbody').on( 'click', 'tr td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows.push( tr.attr('id') );
                    }
                }
            } );

            // On each draw, loop over the `detailRows` array and show any child rows
            dt.on( 'draw', function () {
                $.each( detailRows, function ( i, id ) {
                    $('#'+id+' td.details-control').trigger( 'click' );
                } );
            } );
        });

        function format ( d ) {
            return 'Full name: '+d.first_name+' '+d.last_name+'<br>'+
                'Salary: '+d.salary+'<br>'+
                'The child row can contain any data you wish, including links, images, inner tables etc.';
        }

        /*function format(data) {
            var sTable =
                '<div class="details-container">' +
                '<div class="sec-table-div">' +
                '<span class="sec-table-title">Sugrupo</span>' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-bordered table-striped details-table">' +
                '<tr>' +
                '<td class="title">Grupo:</td>' +
                '<td>' + data.Subgrupo.Grupo.Nome + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Nome:</td>' +
                '<td>' + data.Subgrupo.Nome + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Observação:</td>' +
                '<td>' + data.Subgrupo.Observacao + '</td>' +
                '</tr>' +
                '</table>' +
                '</div>' +
                '<hr>' +
                '<div class="sec-table-div">' +
                '<span class="sec-table-title">Investimento</span>' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-bordered table-striped details-table">' +
                '<tr>' +
                '<td class="title">Descrição:</td>' +
                '<td>' + data.Investimento.Descricao + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Observação:</td>' +
                '<td>' + data.Investimento.Observacao + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Data do cadastro:</td>' +
                '<td>' + data.Investimento.DataCadastro + '</td>' +
                '<td class="title">Data de atualização:</td>' +
                '<td>' + data.Investimento.DataAtualizacao + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Situação:</td>' +
                '<td>' + data.Investimento.Situacao + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Total:</td>' +
                '<td>' + data.Investimento.Total + '</td>' +
                '</tr>' +
                '<tr>' +
                '<table cellpadding="5" cellspacing="0" border="0" class="table table-bordered table-striped details-table">' +
                '<tr>' +
                '<td class="title">Descrição:</td>' +
                '<td>' + data.Investimento.Cronograma.Nome + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Observação:</td>' +
                '<td>' + data.Investimento.Cronograma.Observacao + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Ano Inicial:</td>' +
                '<td>' + data.Investimento.Cronograma.AnoInicial + '</td>' +
                '<td class="title">Ano Final:</td>' +
                '<td>' + data.Investimento.Cronograma.AnoFinal + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td class="title">Situação:</td>' +
                '<td>' + data.Investimento.Situacao + '</td>' +
                '</tr>' +
                '</table>' +
                '</tr>' +
                '</table>' +
                '</div>' +
                '</div>';
            return sTable;
        }*/

    </script>

@endsection