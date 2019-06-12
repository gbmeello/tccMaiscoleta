@extends('layouts.app')

@section('contentHeader')
    <h1>
        Fardo
        <small>Cadastro</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{url('fardo/index')}}"><i class="fa fa-users"></i> Fardo</a></li>
        <li class="active">Cadastro</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Cadastro de Fardo</h3>
                </div>
                <form id="form-fardo" class="box-body">
                    @csrf
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_tipo_residuo">Tipo de Res&iacute;duo</label>
                            <div class="input-group">
                                <select name="slt_tipo_residuo" class="form-control" style="width: 100%;" id="slt_tipo_residuo">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat"
                                        onclick="loadSelect2('tipo-residuo/listar', '#slt_tipo_residuo', 'pk_tipo_residuo', 'nome')"
                                        data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>" type="button">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_cliente_final">Cliente Final</label>
                            <div class="input-group">
                                <select name="slt_cliente_final" class="form-control" style="width: 100%;" id="slt_cliente_final">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat"
                                        onclick="loadSelect2('cliente-final/listar', '#slt_cliente_final', 'pk_cliente_final', 'razao_social')"
                                        data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>" type="button">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_triagem">Triagem</label>
                            <div class="input-group">
                                <select name="slt_triagem" class="form-control" style="width: 100%;" id="slt_triagem">
                                    <option value=""> Selecione uma opção... </option>
                                </select>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary btn-flat"
                                        onclick="loadSelect2('triagem/listar', '#slt_triagem', 'pk_triagem', 'data_triagem')"
                                        data-loading-text="<i class='fas fa-sync-alt fa-spin'></i>" type="button">
                                        <i class="fa fa-sync-alt"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label" for="slt_status">Status</label>
                            <div class="input-group">
                                <select name="slt_status" class="form-control" style="width: 100%;" id="slt_status">
                                    <option value=""> Selecione uma opção... </option>
                                    @isset($status)
                                        @foreach ($status as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="data_venda">Data de Venda:</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" name="data_venda" id="data_venda" class="form-control datepicker">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="lote">Lote:</label>
                            <input type="number" name="lote" id="lote" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="peso">Peso:</label>
                            <div class="input-group">
                                <input type="number" name="peso" id="peso" class="form-control">
                                <span class="input-group-btn">
                                    <label>ADSADASDSA</label>
                                    <select style="width: 25%;" name="slt_unidade_medida" class="form-control" style="width: 100%;" id="slt_unidade_medida">
                                        @isset($unidadesMedida)
                                            @foreach ($unidadesMedida as $key => $value)
                                                <option value="{{$key}}">{{$value}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="slt_status">Status</label>
                            <div class="input-group">
                                <select name="slt_status" class="form-control" style="width: 100%;" id="slt_status">
                                    <option value=""> Selecione uma opção... </option>
                                    @isset($status)
                                        @foreach ($status as $key => $value)
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    @endisset
                                </select>
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


            $('#slt_tipo_residuo').select2();
            $('#slt_cliente_final').select2();
            $('#slt_triagem').select2();

            $('.datepicker').datetimepicker({
                locale: 'pt-br'
            });

            loadSelect2('cliente-final/listar', '#slt_cliente_final', 'pk_cliente_final', 'razao_social');
            loadSelect2('tipo-residuo/listar', '#slt_tipo_residuo', 'pk_tipo_residuo', 'nome');
            loadSelect2('triagem/listar', '#slt_triagem', 'pk_triagem', 'data_triagem')

            $('#btn-salvar').unbind('click').click(function() {
                cadastrar();
            });
        });

        // function initValidation() {

        //     $('#telefone1').inputmask('(99) 999999999');  //static mask
        //     $('#telefone2').inputmask('(99) 999999999');  //static mask
        //     $('#data_venda').date('99999-999');  //static mask

        // }

        function cadastrar() {

            let data = $('#form-fardo').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'POST',
                url: '/api/v1/fardo/cadastrar',
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