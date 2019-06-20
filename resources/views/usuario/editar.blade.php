@extends('layouts.app')

@section('contentHeader')
    <h1>
        Usuários
        <small>Edição</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="{{asset('usuario/index')}}"><i class="fa fa-user"></i> Usuários</a></li>
        <li class="active">Edição</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar Usuários - [{{ $obj->nome }}]</h3>
                </div>
                <form id="form-usuario" class="box-body">
                    @csrf
                    <input type="hidden" name="pk_usuario" id="pk_usuario" value="{{ $obj->nome }}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="nome">Nome</label>
                            <input type="text" class="form-control" value="{{ $obj->nome }}" name="nome" id="nome" maxlength="150">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label" for="slt_perfil">Perfil</label>
                        <select name="slt_perfil" class="form-control" style="width: 100%;" id="slt_perfil">
                            <option value=""> Selecione uma opção... </option>
                            @isset($perfis)
                                @foreach ($perfis as $key => $value)
                                    @if($obj->role()->first()->pk_role === $value->pk_role)
                                        <option selected value="{{$value->pk_role}}">{{$value->nome}}</option>
                                    @else
                                        <option value="{{$value->pk_role}}">{{$value->nome}}</option>
                                    @endif
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label" for="email">Email</label>
                            <input type="text" class="form-control" value="{{ $obj->email }}" name="email" id="email" maxlength="200">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="senha">Senha</label>
                            <input type="password" class="form-control" name="senha" id="senha" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="confirmar_senha">Confirmar Senha</label>
                            <input type="password" class="form-control" name="confirmar_senha" id="confirmar_senha" maxlength="100">
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
            $('#btn-salvar').unbind('click').click(function() {
                editar();
            });
        });

        function editar() {

            let data = $('#form-usuario').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'PUT',
                url: '/api/v1/usuario/editar/' + {{ $obj->pk_usuario }},
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