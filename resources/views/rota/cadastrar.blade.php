@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Ve&iacute;culos</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="rota-placa">Nome</label>
                            <input type="text" class="form-control" id="txt-rota-placa" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="rota-observacao">Observa&ccedil;&atilde;o</label>
                            <textarea rows="4" id="txt-rota-observacao" class="form-control" maxlength="500"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-rota-salvar" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                    <br>
                    <div class="clearfix"></div>
                    <br>
                    <div id="div-resultado"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        $(document).ready(function() {
            $('#btn-rota-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let nome       = $('#txt-rota-nome').val();
            let observacao  = $('#txt-rota-observacao').val();

            $.post(
                '{{url('api/v1/rota/cadastrar')}}',
                {
                    nome: nome,
                    observacao: observacao
                },
                function(data, xhr) {
                    if(data.hasSuccess) {
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data));
                    }
                }
            );
        }

    </script>

@endsection