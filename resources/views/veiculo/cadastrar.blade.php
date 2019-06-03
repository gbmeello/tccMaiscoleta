@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Ve&iacute;culos</h3>
                </div>
                <form id="form-veiculo" class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="placa">Placa</label>
                            <input type="text" class="form-control" name="placa" id="placa" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="tipo">Tipo</label>
                            <input type="text" class="form-control" name="tipo" id="tipo" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="modelo">Modelo</label>
                            <input type="text" class="form-control" name="modelo" id="modelo" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="observacao">Observa&ccedil;&atilde;o</label>
                            <textarea rows="4" id="observacao" name="observacao" class="form-control" maxlength="300"></textarea>
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <button id="btn-salvar" class="btn btn-success btn-flat" data-loading-text="<i class='fa fa-save'></i> Salvar <i class='fa fa-spinner fa-spin'></i>">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        $(document).ready(function() {
            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let data = $('#form-fornecedor').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'POST',
                url: '/api/v1/veiculo/cadastrar',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    $btnSalvar.button('loading');
                },
                complete: function() {
                    $btnSalvar.button('reset');
                },
                success: function(data) {
                    if(data.success) {
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
                    }

                },
                error: function(xhr, response) { // if error occured
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
                }
            });

        }

    </script>

@endsection