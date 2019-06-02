@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro da Coleta</h3>
                </div>
                <form id="form-triagem" class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_veiculo">Fornecedor</label>
                            <select name="slt_fornecedor" id="slt_fornecedor">
                                @if(isset($fornecedores) && $fornecedores->exists())
                                    <option value=""> Selecione o fornecedor... </option>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{$fornecedor->pk_fornecedor}}"> {{$fornecedor->nome_fantasia}} </option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum fornecedor foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_veiculo">Veículo</label>
                            <select name="slt_veiculo" id="slt_veiculo">
                                @if(isset($veículos) && $veículos->exists())
                                    <option value=""> Selecione o cliente... </option>
                                    @foreach($veículos as $veículo)
                                        <option value="{{$veículo->pk_veiculo}}"> {{$veículo->tipo}} | {{$veículo->modelo}} | {{$veículo->placa}}</option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum veículo foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_veiculo">Fornecedor</label>
                            <select name="slt_fornecedor" id="slt_fornecedor">
                                @if(isset($fornecedores) && $fornecedores->exists())
                                    <option value=""> Selecione o fornecedor... </option>
                                    @foreach($fornecedores as $fornecedor)
                                        <option value="{{$fornecedor->pk_fornecedor}}"> {{$fornecedor->nome_fantasia}} </option>
                                    @endforeach
                                @else
                                    <option value=""> Nenhum fornecedor foi cadastrado... </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Data de Coleta:</label>
                            <input type="date" class="form-control" name="data_coleta" id="data_coleta">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Teve coleta?</label>
                            <input type="checkbox" class="form-control" name="chk_coleta" id="chk_coleta">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="observacao">Descrição</label>
                            <textarea rows="4" id="observacao" name="observacao" class="form-control" maxlength="1000"></textarea>
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