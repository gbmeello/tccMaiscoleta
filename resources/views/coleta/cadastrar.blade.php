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
                            <input type="text" class="form-control" id="txt-tipo-residuo-nome" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="tipo-residuo-nome">Descrição</label>
                            <textarea rows="4" id="txt-tipo-residuo-descricao" class="form-control" maxlength="600"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-tipo-residuo-salvar" class="btn btn-success btn-flat">
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

    <script>

        $(document).ready(function() {
            $('#btn-tipo-residuo-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let nome        = $('#txt-tipo-residuo-nome').val();
            let descricao   = $('#txt-tipo-residuo-descricao').val();

            $.post(
                '{{url('api/v1/tipo-residuo/cadastrar')}}',
                {
                    nome: nome,
                    descricao: descricao
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