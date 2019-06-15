@extends('layouts.app')

@section('contentHeader')
    <h1>
        Triagem
        <small>Cadastro</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{url('triagem/index')}}"><i class="fa fa-filter"></i> Triagem</a></li>
        <li class="active">Cadastro</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Triagem</h3>
                </div>
                <form id="form-triagem" class="box-body">
                    @csrf
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="slt_coleta">Coleta</label>
                            <div class="input-group">
                                <select name="slt_coleta" class="form-control" style="width: 100%;" id="slt_coleta">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" onclick="loadSelect2('coleta/listar', '#slt_coleta', 'pk_coleta', 'data_coleta|rota_nome')" data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>" type="button">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="data_triagem">Data de Triagem:</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" name="data_triagem" id="data_triagem" class="form-control datepicker">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="observacao">Observação:</label>
                            <textarea id="observacao" name="observacao" class="form-control" rows="4" maxlength="1000"></textarea>
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

            $('#slt_coleta').select2();

            $('.datepicker').datetimepicker({
                locale: 'pt-br'
            });

            loadSelect2('coleta/listar', '#slt_coleta', 'pk_coleta', 'data_coleta|rota_nome');

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function cadastrar() {

            let data = $('#form-triagem').serialize();
            let $btnSalvar = $('#btn-salvar');

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
                        $('#div-resultado').html(showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(showValidationErrors(data.message));
                    }

                },
                error: function(xhr) { // if error occured
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
                }
            });
        }

    </script>

@endsection