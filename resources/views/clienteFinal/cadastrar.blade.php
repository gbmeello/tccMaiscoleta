@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Fornecedores</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-nome-fantasia">Nome Fantasia</label>
                            <input type="text" class="form-control" id="txt-fornecedor-nome-fantasia" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-razao-social">Razão Social</label>
                            <input type="text" class="form-control" id="txt-fornecedor-razao-social" maxlength="300">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-email">Email</label>
                            <input type="text" class="form-control" id="txt-fornecedor-email" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-telefone1">Telefone 1:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-telefone1" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-telefone1">Telefone 2:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-telefone2" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-estado">Estado:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-estado" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-cidade">Cidade:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-cidade" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-cidade">Cep:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-cidade" maxlength="8">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-cidade">Bairro:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-cidade" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-rua">Rua:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-rua" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-logradouro">Logradouro:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-logradouro" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="txt-fornecedor-complemento">Complemento:</label>
                            <input type="text" class="form-control" id="txt-fornecedor-complemento" maxlength="300">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-veiculo-salvar" class="btn btn-success btn-flat">
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

    <script src="{{ asset('/js/helper.js') }}"></script>
    <script>

        $(document).ready(function() {
            $('#btn-veiculo-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let placa       = $('#txt-veiculo-placa').val();
            let tipo        = $('#txt-veiculo-tipo').val();
            let modelo      = $('#txt-veiculo-modelo').val();
            let observacao  = $('#txt-veiculo-observacao').val();

            $.post(
                '{{url('api/v1/veiculo/cadastrar')}}',
                {
                    placa: placa,
                    tipo: tipo,
                    modelo: modelo,
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