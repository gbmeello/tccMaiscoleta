@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Triagem</h3>
                </div>
                <form id="form-triagem" class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_coleta">Coleta</label>
                            <select name="slt_coleta" id="slt_coleta">
                                @if($clientesFinais->exists())
                                    <option value=""> Selecione a coleta... </option>
                                    @foreach($coletas as $coleta)
                                        <option value="{{$coleta->pk_coleta}}"> {{$coleta->nome}} </option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum cliente foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_cliente_final">Cliente Final</label>
                            <select name="slt_cliente_final" id="slt_cliente_final">
                                @if($clientesFinais->exists())
                                    <option value=""> Selecione o cliente... </option>
                                    @foreach($clientesFinais as $cliente)
                                        <option value="{{$cliente->pk_cliente_final}}"> {{$cliente->nome_fantasia}} </option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum cliente foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_tipo_residuo">Tipo de Res&iacute;duo</label>
                            <select name="slt_tipo_residuo" id="slt_tipo_residuo">
                                @if($tipoResiduos->exists())
                                    <option value=""> Selecione o tipo de res&iacute;duo... </option>
                                    @foreach($tipoResiduos as $tipoResiduo)
                                        <option value="{{$tipoResiduo->pk_tipo_residuo}}"> {{$tipoResiduo->nome}} </option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum tipo de resíduo foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Data de Triagem:</label>
                            <input type="text" class="form-control" name="data_triagem" id="data_triagem">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Data de Venda:</label>
                            <input type="date" class="form-control" name="data_venda" id="data_venda">
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <button id="btn-salvar" class="btn btn-success btn-flat" data-loading-text="<i class='fa fa-spinner fa-spin'></i>">
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

            let $btnSalvar = $('#btn-salvar');

            let data = $('#form-triagem').serialize();

            $.ajax({
                type: 'POST',
                url: '/api/v1/triagem/cadastrar',
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