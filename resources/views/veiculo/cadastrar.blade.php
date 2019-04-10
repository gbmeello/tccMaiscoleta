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
                            <label  class="control-label" for="veiculo-placa">Placa</label>
                            <input type="text" class="form-control" id="veiculo-placa" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label" for="veiculo-tipo">Tipo</label>
                            <input type="text" class="form-control" id="veiculo-tipo" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="veiculo-modelo">Modelo</label>
                            <input type="text" class="form-control" id="veiculo-modelo" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="veiculo-observacao">Observa&ccedil;&atilde;o</label>
                            <textarea rows="4" id="veiculo-observacao" class="form-control" maxlength="300"></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button id="btn-tipo-residuo-salvar" class="btn btn-success btn-flat">
                        <i class="fa fa-save"></i> Salvar
                    </button>
                    <br>
                    <div id="resultado"></div>
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

            let nome = $('#tipo-residuo-nome').val();
            let descricao = $('#txt-tipo-residuo-descricao').val();

            $.post(
                '{{url('api/tipo-residuo/cadastrar')}}',
                {
                    nome: nome,
                    descricao: descricao
                },
                function(data, xhr) {

                    if(data.hasSuccess) {


                        $('#resultado').html();

                        alert(data.message);
                    } else {

                        console.log(data.message)
                        if(Array.isArray(data.message)) {
                            $.each(data.message, function(i, el) {
                                console.log(el);
                            });
                        }

                        alert(data.message);
                    }
                }
            );
        }

    </script>

@endsection