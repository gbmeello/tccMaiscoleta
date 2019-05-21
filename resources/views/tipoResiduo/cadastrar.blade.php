@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Tipo de res&iacute;duos</h3>
                </div>
                <form id="form-tipo-residuo" role="form" class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label" for="txt-tipo-residuo-nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="tipo-residuo-nome">Descrição</label>
                            <textarea rows="4" id="descricao" name="descricao" class="form-control" maxlength="600"></textarea>
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <button id="btn-salvar" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Salvar
                    </button>
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
            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let data = $('#form-tipo-residuo').serialize();

            $.ajax({
                type: 'POST',
                url: '/api/v1/tipo-residuoju/cadastrar',
                data: data,
                dataType: 'json',
                beforeSend: function() {
                    console.log('antes de enviar');
                },
                complete: function() {
                    console.log('completo');
                },
                success: function(data) {

                    if(data.hasSuccess) {
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
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