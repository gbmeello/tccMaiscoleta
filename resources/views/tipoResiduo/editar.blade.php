@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title">Editar Tipo de res&iacute;duos - {{$obj->nome}}</h3>
                </div>
                <form id="form-tipo-residuo" role="form" class="box-body">
                    <input name="pk_tipo_residuo" id="pk_tipo_residuo" hidden value="{{$obj->pk_tipo_residuo}}">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label  class="control-label" for="nome">Nome</label>
                            <input type="text" class="form-control" value="{{$obj->nome}}" id="nome" name="nome" maxlength="100">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label  class="control-label" for="descricao">Descrição</label>
                            <textarea rows="4" id="descricao" name="descricao" class="form-control" maxlength="600">{{$obj->descricao}}</textarea>
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
                editar();
            });
        });

        function editar() {

            let data = $('#form-tipo-residuo').serialize();

            $.ajax({
                type: 'PUT',
                url: '/api/v1/tipo-residuo/editar/' + {{$obj->pk_tipo_residuo}},
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
                        $('#div-resultado').html(Helper.showMessage('success', data.message));
                    } else {
                        $('#div-resultado').html(Helper.showValidationErrors(data.message));
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