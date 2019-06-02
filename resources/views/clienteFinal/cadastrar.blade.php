@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro do Cliente Final</h3>
                </div>
                <form id="form-cliente-final" role="form" class="box-body">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="nome_fantasia">Nome Fantasia</label>
                            <input type="text" class="form-control" name="nome_fantasia" id="nome_fantasia" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="razao_social">Razão Social</label>
                            <input type="text" class="form-control" name="razao_social" id="razao_social" maxlength="300">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Telefone 1:</label>
                            <input type="text" class="form-control" name="telefone1" id="telefone1" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Telefone 2:</label>
                            <input type="text" class="form-control" name="telefone2" id="telefone2" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="estado">Estado:</label>
                            <select id="slt_estado" class="form-control" name="slt_estado">
                                <option value="">Selecione o estado...</option>
                                @foreach ($estados as $estado)
                                    <option value="{{$estado->pk_estado}}">{{$estado->nome}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="slt_municipio">Município:</label>
                            <select id="slt_municipio" class="form-control" name="slt_municipio">
                                <option value="">...</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="cep">Cep:</label>
                            <input type="text" class="form-control" name="cep" id="cep" maxlength="9">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="bairro">Bairro:</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="rua">Rua:</label>
                            <input type="text" class="form-control" name="rua" id="rua" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="logradouro">Logradouro:</label>
                            <input type="text" class="form-control" name="logradouro" id="logradouro" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="complemento">Complemento:</label>
                            <input type="text" class="form-control" name="complemento" id="complemento" maxlength="300">
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

            initValidation();

            $sltEstado = $('#slt_estado').select2();

            $sltEstado.change(function() {
                HelperJs.loadSelectMunicipios('#slt_municipio', $sltEstado.val());
            });

            $sltMunicipio = $('#slt_municipio');
            $sltMunicipio.select2();

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function initValidation() {

            $('#telefone1').inputmask('(99) 999999999');  //static mask
            $('#telefone2').inputmask('(99) 999999999');  //static mask
            $('#cep').inputmask('99999-999');  //static mask

        }

        function cadastrar() {

            let data = $('#form-cliente-final').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'POST',
                url: '/api/v1/cliente-final/cadastrar',
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