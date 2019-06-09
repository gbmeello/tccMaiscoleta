@extends('layouts.app')

@section('contentHeader')
    <h1>
        Triagem
        <small>Edição</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{url('triagem/index')}}"><i class="fa fa-filter"></i> Triagem</a></li>
        <li class="active">Edição</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Edição do Fornecedor - [{{$obj->nome_fantasia}}]</h3>
                </div>
                <form id="form-fornecedor" role="form" class="box-body">
                    <input name="pk_cliente_final" value="{{ $obj->pk_cliente_final }}" hidden>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="nome_fantasia">Nome Fantasia</label>
                            <input type="text" class="form-control" value="{{ $obj->nome_fantasia }}" name="nome_fantasia" id="nome_fantasia" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="razao_social">Razão Social</label>
                            <input type="text" class="form-control" value="{{ $obj->razao_social }}" name="razao_social" id="razao_social" maxlength="300">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" class="form-control" value="{{ $obj->email }}"  name="email" id="email" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Telefone 1:</label>
                            <input type="text" class="form-control" value="{{ $obj->telefone1 }}"  name="telefone1" id="telefone1" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="telefone1">Telefone 2:</label>
                            <input type="text" class="form-control" value="{{ $obj->telefone2 }}"  name="telefone2" id="telefone2" maxlength="15">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="estado">Estado:</label>
                            <input type="text" class="form-control" value="{{ $obj->estado }}"  name="estado" id="estado" maxlength="50">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="cidade">Cidade:</label>
                            <input type="text" class="form-control" value="{{ $obj->cidade }}"  name="cidade" id="cidade" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="cep">Cep:</label>
                            <input type="text" class="form-control" value="{{ $obj->cep }}"  name="cep" id="cep" maxlength="8">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="bairro">Bairro:</label>
                            <input type="text" class="form-control" value="{{ $obj->bairro }}"  name="bairro" id="bairro" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="rua">Rua:</label>
                            <input type="text" class="form-control" value="{{ $obj->rua }}"  name="rua" id="rua" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="logradouro">Logradouro:</label>
                            <input type="text" class="form-control" value="{{ $obj->logradouro }}"  name="logradouro" id="logradouro" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="complemento">Complemento:</label>
                            <input type="text" class="form-control" value="{{ $obj->complemento }}"  name="complemento" id="complemento" maxlength="300">
                        </div>
                    </div>
                </form>
                <div class="box-footer">
                    <button id="btn-salvar" class="btn btn-success btn-flat">
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

            $.ajax({
                type: 'PUT',
                url: '/api/v1/fornecedor/editar/'+{{ $obj->pk_cliente_final }},
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
                }
            });
        }

    </script>

@endsection