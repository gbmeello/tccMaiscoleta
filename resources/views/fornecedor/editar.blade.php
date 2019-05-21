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
                            <label class="control-label" for="veiculo-placa">Placa</label>
                            <input type="text" class="form-control" id="txt-veiculo-placa" maxlength="10">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="veiculo-tipo">Tipo</label>
                            <input type="text" class="form-control" id="txt-veiculo-tipo" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="veiculo-modelo">Modelo</label>
                            <input type="text" class="form-control" id="txt-veiculo-modelo" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="veiculo-observacao">Observa&ccedil;&atilde;o</label>
                            <textarea rows="4" id="txt-veiculo-observacao" class="form-control" maxlength="300"></textarea>
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