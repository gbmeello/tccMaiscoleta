@extends('layouts.app')

@section('contentHeader')
    <h1>
        Coleta
        <small>Edição</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{ url('coleta/index') }}"><i class="fa fa-truck-loading"></i> Coleta</a></li>
        <li class="active">Edição</li>
    </ol>
@endsection

@php dd($obj->get()) @endphp;

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Edição da Coleta - [{{ $obj->data_coleta }} / {{ $obj->rota()->nome }}]</h3>
                </div>
                <form id="form-coleta" class="box-body">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_rota">Rota</label>
                            <div class="input-group">
                                <select naname="slt_rota" class="form-control" style="width: 100%;" id="slt_rota">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="button" onclick="loadSelect2WithValue( 'rota/listar', '#slt_rota', 'pk_rota', 'nome', {{ $obj->fk_rota }} );" data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_veiculo">Veículo</label>
                            <div class="input-group">
                                <select name="slt_veiculo" class="form-control" style="width: 100%;" id="slt_veiculo">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="button" onclick="loadSelect2WithValue( 'veiculo/listar', '#slt_veiculo', 'pk_veiculo', 'placa|modelo', {{ $obj->fk_veiculo }} )" data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_fornecedor">Fornecedor</label>
                            <div class="input-group">
                                <select naname="slt_fornecedor" class="form-control" style="width: 100%;" id="slt_fornecedor">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat" type="button" onclick="loadSelect2WithValue( 'fornecedor/listar', '#slt_fornecedor', 'pk_fornecedor', 'razao_social', {{ $obj->fk_fornecedor }} )" data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="data_coleta">Data de Coleta:</label>
                            <input type="date" class="form-control" name="data_coleta" id="data_coleta">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="has_coleta">Teve coleta?</label>
                            <br>
                            <input type="checkbox" value="{{ $obj->has_coleta }}" class="" name="has_coleta" id="has_coleta">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="observacao">Observação</label>
                            <textarea rows="4" id="observacao" name="observacao" class="form-control" maxlength="1000">
                                {{ $obj->observacao }}
                            </textarea>
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

            initValidation();

            $('#slt_rota').select2();
            $('#slt_veiculo').select2();
            $('#slt_fornecedor').select2();

            loadSelect2WithValue( 'rota/listar', '#slt_rota', 'pk_rota', 'nome', {{ $obj->fk_rota }} );
            loadSelect2WithValue( 'rota/listar', '#slt_rota', 'pk_rota', 'nome', {{ $obj->fk_rota }} );
            loadSelect2WithValue( 'fornecedor/listar', '#slt_fornecedor', 'pk_fornecedor', 'nome', {{ $obj->fk_fornecedor }} );

            document.getElementById('data_coleta').value = '{{ $obj->data_coleta }}';

            $('#has_coleta').prop('checked', {{ $obj->has_coleta }});

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        function initValidation() {

            // $('#data_coleta').inputmask('__/__/____');  //static mask

        }

        function cadastrar() {

            let $btnSalvar = $('#btn-salvar');

            let data = $('#form-coleta').serialize();

            $.ajax({
                type: 'PUT',
                url: '/api/v1/coleta/editar' + {{ $obj->pk_coleta }},
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
                error: function(xhr, response) { // if error occured
                    $('#div-resultado').html(showValidationErrors(xhr.responseJSON.message));
                }
            });
        }

    </script>

@endsection