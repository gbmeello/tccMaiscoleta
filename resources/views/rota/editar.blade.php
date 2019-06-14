@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-centered">
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">Editar Rota - [{{$obj->nome}}]</h3>
            </div>
            <form id="form-rota" role="form" class="box-body">
                @csrf
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="nome">Nome</label>
                        <input type="text" class="form-control" value="{{$obj->nome}}" name="nome" id="nome"
                            maxlength="100">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="observacao">Observa&ccedil;&atilde;o</label>
                        <textarea rows="4" id="observacao" name="observacao" class="form-control" maxlength="500">{{$obj->observacao}}</textarea>
                    </div>
                </div>
            </form>
            <div class="box-footer">
                <button id="btn-salvar" class="btn btn-success btn-flat"
                    data-loading-text="<i class='fa fa-save'></i> Salvar <i class='fa fa-spinner fa-spin'></i>">
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

            let data = $('#form-rota').serialize();
            let $btnSalvar = $('#btn-salvar');

            $.ajax({
                type: 'PUT',
                url: '/api/v1/rota/editar/' + {{$obj->pk_rota}},
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