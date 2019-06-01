@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Tipo de res&iacute;duos</h3>
                </div>
                <div class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label" for="txt-tipo-residuo-nome">Nome</label>
                            <input type="text" class="form-control" id="tipo-residuo-nome" placeholder="Digite o nome do tipo de residuo" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="tipo-residuo-nome">Descrição</label>
                            <textarea rows="4" id="txt-tipo-residuo-descricao" class="form-control" placeholder="Digite a descrição do tipo de resíduo" maxlength="600"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-tipo-residuo-salvar" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script>

        f$(document).ready(function() {
            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let data = $('#form-veiculo').serialize();

            $.ajax({
                type: 'POST',
                url: '/api/v1/veiculo/cadastrar',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    console.log('antes de enviar');
                },
                complete: function() {
                    console.log('completo');
                },
                success: function(data) {

                    if(data.success) {
                        $('#div-resultado').html(HelperJs.showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(HelperJs.showValidationErrors(data.message));
                    }

                },
                error: function(xhr) { // if error occured
                    console.log(xhr);
                    console.error('error');
                }
            });

        }

    </script>

@endsection